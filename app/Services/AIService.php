<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * AIService handles interactions with Google's Gemini AI.
 *
 * This service is responsible for extracting features from images and
 * suggesting prices for garments using Gemini's vision and text models.
 *
 * Configuration:
 * Ensure that the GEMINI_API_KEY is set in your .env file.
 * This key is loaded via the config/gemini.php configuration file.
 */
class AIService
{
    /**
     * Extracts garment features from an image using the Gemini Vision API.
     *
     * The image path is expected to be in the format 'storage/images/uploads/your_image.jpg',
     * which is then resolved relative to the 'storage/app/public/' directory
     * (e.g., 'images/uploads/your_image.jpg' on the 'public' disk).
     *
     * @param string $imagePath The path to the image file as stored in the database.
     * @return array An array containing extracted features like 'color', 'type',
     *               'condition', and 'estimation_basis', or an error array.
     */
    public function extractFeatures(string $imagePath): array
    {
        $apiKey = config('gemini.api_key');
        if (!$apiKey) {
            Log::error('Gemini API key is not configured for feature extraction.');
            return ['error' => 'AI service not configured: missing API key.', 'estimation_basis' => 'error_config'];
        }

        // Adjust path for Storage facade: 'storage/images/uploads/file.jpg' -> 'images/uploads/file.jpg'
        // This assumes the 'public' disk is used for these images.
        $storagePath = Str::startsWith($imagePath, 'storage/') ? Str::after($imagePath, 'storage/') : $imagePath;

        try {
            if (!Storage::disk('public')->exists($storagePath)) {
                Log::error('Image file not found for feature extraction.', ['path' => $storagePath]);
                return ['error' => 'Image file not found.', 'estimation_basis' => 'error_file_not_found'];
            }

            $imageData = Storage::disk('public')->get($storagePath);
            if (!$imageData) { // Should be caught by exists, but as a safeguard
                Log::error('Failed to read image file for feature extraction.', ['path' => $storagePath]);
                return ['error' => 'Failed to read image file.', 'estimation_basis' => 'error_file_read'];
            }
            $base64ImageData = base64_encode($imageData);
            $mimeType = Storage::disk('public')->mimeType($storagePath);

            if (!$mimeType) {
                Log::warning('Could not determine MIME type for image.', ['path' => $storagePath]);
                // Fallback or error if MIME type is crucial and not detectable
                return ['error' => 'Could not determine image MIME type.', 'estimation_basis' => 'error_mime_type'];
            }

            $prompt = "Analyze this image of a garment and extract its primary color,
            type of garment (e.g., shirt, pants, dress),
            and its perceived condition (e.g., new, good, fair, poor).
            Return the answer as a JSON object with keys 'color', 'type', and 'condition'.";

            $geminiVisionEndpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro-vision:generateContent";

            $json_payload = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                            [
                                'inline_data' => [
                                    'mime_type' => $mimeType,
                                    'data' => $base64ImageData
                                ]
                            ]
                        ]
                    ]
                ],
                // 'generationConfig' => [ 'response_mime_type' => 'application/json' ] // If supported
            ];

            $response = Http::timeout(60) // Increased timeout for image uploads
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($geminiVisionEndpoint . '?key=' . $apiKey, $json_payload);

            if ($response->failed()) {
                Log::error('Gemini Vision API request failed.', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return ['error' => 'Failed to extract features from AI service.', 'details' => $response->body(), 'estimation_basis' => 'error_vision_api_call'];
            }

            $responseData = $response->json();
            $extractedFeaturesData = null;

            if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                $jsonText = $responseData['candidates'][0]['content']['parts'][0]['text'];
                $jsonText = trim($jsonText);
                if (strpos($jsonText, '```json') === 0) {
                    $jsonText = str_replace('```json', '', $jsonText);
                    $jsonText = rtrim($jsonText, '`');
                }
                $jsonText = trim($jsonText);

                $extractedFeaturesData = json_decode($jsonText, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('Gemini Vision API response parsing error: Invalid JSON in text part.', ['text_part' => $jsonText, 'original_response_snippet' => substr(is_string($responseData) ? $responseData : json_encode($responseData), 0, 500)]);
                    return ['error' => 'Invalid response format from AI Vision service.', 'estimation_basis' => 'error_vision_parsing'];
                }
            } else {
                Log::error('Gemini Vision API response parsing error: Expected JSON data not found.', ['response_body' => $responseData]);
                return ['error' => 'Unexpected response structure from AI Vision service.', 'estimation_basis' => 'error_vision_parsing_structure'];
            }

            if (!isset($extractedFeaturesData['color']) || !isset($extractedFeaturesData['type']) || !isset($extractedFeaturesData['condition'])) {
                Log::error('Gemini Vision API response error: Missing feature data in response.', ['parsed_data' => $extractedFeaturesData]);
                return ['error' => 'AI Vision service did not return expected feature data.', 'estimation_basis' => 'error_vision_incomplete_data'];
            }

            return [
                'color' => $extractedFeaturesData['color'],
                'type' => $extractedFeaturesData['type'],
                'condition' => $extractedFeaturesData['condition'],
                'estimation_basis' => 'gemini_vision_api',
                // 'raw_response' => $responseData // Optional for debugging
            ];

        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error('Gemini Vision API HTTP RequestException.', [
                'message' => $e->getMessage(),
                'response_body' => $e->response ? $e->response->body() : null,
                'status' => $e->response ? $e->response->status() : null,
            ]);
            return ['error' => 'An HTTP exception occurred while contacting the AI Vision service.', 'estimation_basis' => 'error_vision_http_exception'];
        } catch (\Exception $e) {
            Log::error('Generic exception during Gemini Vision API call.', ['path' => $storagePath, 'exception_message' => $e->getMessage(), 'trace' => substr($e->getTraceAsString(), 0, 1000)]);
            return ['error' => 'An unexpected exception occurred while processing the image for feature extraction.', 'estimation_basis' => 'error_vision_exception'];
        }
    }

    /**
     * Suggests a market price range for a garment based on its features,
     * using the Gemini text generation API.
     *
     * @param array $features An associative array of garment features,
     *                        e.g., ['color' => 'blue', 'type' => 'shirt', 'condition' => 'new'].
     *                        These features are typically obtained via the extractFeatures() method.
     * @return array An array containing suggested 'min_price', 'max_price',
     *               'currency', and 'estimation_basis', or an error array.
     */
    public function getSuggestedPrice(array $features): array
    {
        $apiKey = config('gemini.api_key');
        if (!$apiKey) {
            Log::error('Gemini API key is not configured.');
            return ['error' => 'AI service not configured: missing API key.', 'estimation_basis' => 'error_config'];
        }

        // Basic validation for features
        if (!isset($features['type']) || !isset($features['color']) || !isset($features['condition'])) {
            Log::warning('Missing expected features for price suggestion.', ['features' => $features]);
            return ['error' => 'Insufficient feature information for price suggestion.', 'estimation_basis' => 'error_features'];
        }

        $prompt = "Suggest a market price range (min and max) in USD for a garment with the following characteristics: " .
                  "Type: {$features['type']}, Color: {$features['color']}, Condition: {$features['condition']}. " .
                  "Provide only a JSON object with 'min_price', 'max_price', and 'currency'.";

        // This is a placeholder and might need adjustment for the specific Gemini model/version.
        $geminiEndpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent";

        try {
            $json_payload = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                // Consider adding generationConfig if specific output like direct JSON is needed and supported
                // 'generationConfig' => [
                //     'response_mime_type' => 'application/json',
                // ]
            ];

            $response = Http::timeout(30) // Set a timeout
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($geminiEndpoint . '?key=' . $apiKey, $json_payload);

            if ($response->failed()) {
                Log::error('Gemini API request failed.', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return ['error' => 'Failed to get suggestion from AI service.', 'details' => $response->body(), 'estimation_basis' => 'error_api_call'];
            }

            $responseData = $response->json();

            $suggestedPriceData = null;
            // Standard Gemini API response structure for gemini-pro:generateContent
            if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                $jsonText = $responseData['candidates'][0]['content']['parts'][0]['text'];
                // The response text might contain markdown ```json ... ```, try to strip it
                $jsonText = trim($jsonText);
                if (strpos($jsonText, '```json') === 0) {
                    $jsonText = str_replace('```json', '', $jsonText);
                    $jsonText = rtrim($jsonText, '`');
                }
                 $jsonText = trim($jsonText);


                $suggestedPriceData = json_decode($jsonText, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('Gemini API response parsing error: Invalid JSON in text part.', [
                        'text_part' => $jsonText,
                        'original_response_snippet' => substr(is_string($responseData) ? $responseData : json_encode($responseData), 0, 500)
                        ]);
                    return ['error' => 'Invalid response format from AI service.', 'estimation_basis' => 'error_parsing'];
                }
            } else {
                Log::error('Gemini API response parsing error: Expected JSON data not found in candidates.0.content.parts.0.text.', [
                'response_body' => $responseData
                ]);
                return ['error' => 'Unexpected response structure from AI service.', 'estimation_basis' => 'error_parsing_structure'];
            }

            if (!isset($suggestedPriceData['min_price']) || !isset($suggestedPriceData['max_price'])) {
                Log::error('Gemini API response error: Missing price data in response.', ['parsed_data' => $suggestedPriceData]);
                return ['error' => 'AI service did not return expected price data.', 'estimation_basis' => 'error_incomplete_data'];
            }

            return [
                'min_price' => $suggestedPriceData['min_price'],
                'max_price' => $suggestedPriceData['max_price'],
                'currency' => $suggestedPriceData['currency'] ?? 'USD', // Default currency if not provided
                'estimation_basis' => 'gemini_api',
                // 'raw_response' => $responseData // Optional: include raw response for debugging, can be large
            ];

        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error('Gemini API HTTP RequestException.', [
                'message' => $e->getMessage(),
                'response_body' => $e->response ? $e->response->body() : null,
                'status' => $e->response ? $e->response->status() : null,
            ]);
            return ['error' => 'An HTTP exception occurred while contacting the AI service.', 'estimation_basis' => 'error_http_exception'];
        } catch (\Exception $e) {
            Log::error('Generic exception during Gemini API call.', ['exception_message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return ['error' => 'An unexpected exception occurred while contacting the AI service.', 'estimation_basis' => 'error_exception'];
        }
    }
}
