<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\Benefit;
use App\Models\Entity;
use App\Models\Image;
use App\Models\Product;
use App\Models\Store;
use App\Services\AIService;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Response;

/**
 * Class ImageAPIController
 * @package App\Http\Controllers\API
 *
 * @SWG\Definition(
 *   definition="Image",
 *   type="object",
 *   @SWG\Xml(name="Image"),
 *   @SWG\Property(property="id", type="integer", description="Image ID", readOnly=true),
 *   @SWG\Property(property="src", type="string", description="Image source path"),
 *   @SWG\Property(property="title", type="string", description="Image title"),
 *   @SWG\Property(property="product_id", type="integer", description="Associated product ID"),
 *   @SWG\Property(property="benefit_id", type="integer", description="Associated benefit ID"),
 *   @SWG\Property(property="store_id", type="integer", description="Associated store ID"),
 *   @SWG\Property(property="activity_id", type="integer", description="Associated activity ID"),
 *   @SWG\Property(property="event_id", type="integer", description="Associated event ID"),
 *   @SWG\Property(property="primary", type="integer", description="Is primary image (0 or 1)"),
 *   @SWG\Property(property="created_at", type="string", format="date-time", readOnly=true),
 *   @SWG\Property(property="updated_at", type="string", format="date-time", readOnly=true)
 * )
 *
 * @SWG\Definition(
 *   definition="ImageFeatures",
 *   type="object",
 *   @SWG\Property(property="brand", type="string", description="Detected brand"),
 *   @SWG\Property(property="model", type="string", description="Detected model"),
 *   @SWG\Property(property="color", type="string", description="Detected color"),
 *   @SWG\Property(property="condition", type="string", description="Detected condition"),
 *   @SWG\Property(property="category", type="string", description="Detected category"),
 *   @SWG\Property(property="confidence", type="number", format="float", description="Confidence score")
 * )
 *
 * @SWG\Definition(
 *   definition="PriceSuggestion",
 *   type="object",
 *   @SWG\Property(property="min_price", type="number", format="float", description="Minimum suggested price"),
 *   @SWG\Property(property="max_price", type="number", format="float", description="Maximum suggested price"),
 *   @SWG\Property(property="avg_price", type="number", format="float", description="Average suggested price"),
 *   @SWG\Property(property="currency", type="string", description="Currency code")
 * )
 */
class ImageAPIController extends AppBaseController
{

    private $imageService;
    public function __construct(ImageService $service)
    {
        $this->imageService = $service;
    }

    /**
     * Delete an image by ID.
     *
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/images/delete/{id}",
     *      summary="Delete an image",
     *      tags={"Image"},
     *      security={{"jwt":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          type="integer",
     *          required=true,
     *          description="Image ID"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Image deleted successfully"
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Image not found"
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function delete($id)
    {
        $image = Image::find($id);
        if (!$image) {
            return $this->sendError('Image not found');
        }
        $resp = $image->delete();

        // Eliminar el archivo físico
        if (Storage::disk('public')->exists($image->src)) {
            Storage::disk('public')->delete($image->src);
        }

        return $this->sendSuccess('Image deleted successfully');

    }

    /**
     * Upload images for a product.
     *
     * @param Request $request
     * @param int $productId
     * @return Response
     *
     * @SWG\Post(
     *      path="/images/product/{productId}/upload",
     *      summary="Upload images for a product",
     *      tags={"Image"},
     *      security={{"jwt":{}}},
     *      @SWG\Parameter(
     *          name="productId",
     *          in="path",
     *          type="integer",
     *          required=true,
     *          description="Product ID"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          required=true,
     *          description="Array of base64 encoded images",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="images",
     *                  type="array",
     *                  @SWG\Items(
     *                      type="object",
     *                      @SWG\Property(property="src", type="string", description="Base64 encoded image data URI")
     *                  )
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Images uploaded successfully",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="success", type="boolean"),
     *              @SWG\Property(property="message", type="string"),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Image")
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Product not found"
     *      ),
     *      @SWG\Response(
     *          response=500,
     *          description="Error uploading images"
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function uploadProductImage(Request $request, $productId)
    {

        try {
            $product = Product::findOrFail($productId);
            $images = $request->input('images');
            $savedImages = [];
            Image::where('product_id', $productId)->delete();

            foreach ($images as $image) {
                // Decodificar la imagen base64
                if (preg_match('/^data:image\/(\w+);base64,/', $image['src'])) {
                    $data = substr($image['src'], strpos($image['src'], ',') + 1);
                    $data = base64_decode($data);

                    // Crear nombre único para la imagen
                    $fileName = 'product_' . $productId . '_' . uniqid() . '.png';

                    // Guardar la imagen en el storage
                    Storage::disk('public')->put('products/' . $fileName, $data);

                    // Crear registro en la base de datos
                    $productImage = Image::create([
                        'product_id' => $productId,
                        'src' => 'storage/products/' . $fileName,
                        'title' => $fileName,
                    ]);

                    $savedImages[] = $productImage;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Imágenes guardadas correctamente',
                'data' => $savedImages
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar las imágenes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete all images for a product.
     *
     * @param int $productId
     * @return Response
     *
     * @SWG\Delete(
     *      path="/images/product/{productId}/delete",
     *      summary="Delete all images for a product",
     *      tags={"Image"},
     *      security={{"jwt":{}}},
     *      @SWG\Parameter(
     *          name="productId",
     *          in="path",
     *          type="integer",
     *          required=true,
     *          description="Product ID"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Images deleted successfully"
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="No images found for product"
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function deleteProductImage($productId)
    {
        try {
            DB::beginTransaction();

            // Obtener todas las imágenes asociadas al producto
            $images = Image::where('product_id', $productId)->get();

            if ($images->isEmpty()) {
                return $this->sendError('No se encontraron imágenes para este producto');
            }

            foreach ($images as $image) {
                // Obtener la ruta del archivo
                $filePath = str_replace('storage/', '', $image->src);

                // Eliminar el archivo físico
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }

                // Eliminar el registro de la base de datos
                $image->delete();
            }

            DB::commit();
            return $this->sendSuccess('Imágenes eliminadas correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Error al eliminar las imágenes: ' . $e->getMessage());
        }


    }

    /**
     * Upload a single image.
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/images/upload",
     *      summary="Upload a single image file",
     *      tags={"Image"},
     *      security={{"jwt":{}}},
     *      consumes={"multipart/form-data"},
     *      @SWG\Parameter(
     *          name="image",
     *          in="formData",
     *          type="file",
     *          required=true,
     *          description="Image file to upload"
     *      ),
     *      @SWG\Parameter(
     *          name="product_id",
     *          in="formData",
     *          type="integer",
     *          required=false,
     *          description="Associated product ID"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Image uploaded successfully",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", description="Image ID"),
     *              @SWG\Property(property="src", type="string", description="Image source URL")
     *          )
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="No image file provided"
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function uploadImage(Request $request)
    {

        $input = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $type = $input['type'] ?? 'product';
            $storeId = $input['store_id'] ?? null;
            $store = $storeId ? Store::find($storeId) : null;

            $path = $this->imageService->upload($request->file('image'), $type, $store);

            $newImage = [
                'primary' => $input['primary'] ?? null,
                'title' => $filename,
                'src' => $path,
                'product_id' => $input['product_id'] ?? null,
                'store_id' => $input['store_id'] ?? null,
            ];

            $resp['src'] = $path;
            $resp['id'] = DB::table('images')->insertGetId($newImage);

            return response()->json($resp);
        } else {
            return response()->json(404);
        }
    }

    /**
     * Get AI-based price suggestion for an image.
     *
     * @param int $id
     * @param AIService $aiService
     * @return Response
     *
     * @SWG\Post(
     *      path="/images/{id}/suggest_price",
     *      summary="Get AI-based price suggestion for an image",
     *      tags={"Image"},
     *      security={{"jwt":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          type="integer",
     *          required=true,
     *          description="Image ID"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Price suggestion retrieved successfully",
     *          @SWG\Schema(ref="#/definitions/PriceSuggestion")
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Image not found"
     *      ),
     *      @SWG\Response(
     *          response=422,
     *          description="Could not extract features for the image"
     *      ),
     *      @SWG\Response(
     *          response=500,
     *          description="Error processing price suggestion"
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function suggestPrice($id, AIService $aiService)
    {
        $image = Image::find($id);

        if (!$image) {
            return $this->sendError('Image not found.', 404);
        }

        $imagePath = $image->src; // As used in extractFeatures method

        try {
            // Step 1: Extract features
            // AIService::extractFeatures returns an array directly (not a Response object)
            $features = $aiService->extractFeatures($imagePath);

            // Optional: Check if features are empty or indicate an error if AIService was designed that way
            if (empty($features)) {
                // This check depends on how AIService::extractFeatures signals error/no features
                return $this->sendError('Could not extract features for the image.', 422);
            }

            // Step 2: Get suggested price based on features
            // AIService::getSuggestedPrice returns an array
            $suggestedPrice = $aiService->getSuggestedPrice($features);

            if (empty($suggestedPrice)) {
                 return $this->sendError('Could not retrieve price suggestion.', 500);
            }

            return $this->sendResponse($suggestedPrice, 'Price suggestion retrieved successfully.');

        } catch (\Exception $e) {
            // Log::error("Price suggestion failed for image ID {$id}: " . $e->getMessage());
            // Differentiate between feature extraction failure and price suggestion failure if possible
            return $this->sendError('An error occurred while processing the image for price suggestion.', 500);
        }
    }

    /**
     * Extract features from an image using AI.
     *
     * @param int $id
     * @param AIService $aiService
     * @return Response
     *
     * @SWG\Post(
     *      path="/images/{id}/extract_features",
     *      summary="Extract features from an image using AI",
     *      tags={"Image"},
     *      security={{"jwt":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          type="integer",
     *          required=true,
     *          description="Image ID"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Image features extracted successfully",
     *          @SWG\Schema(ref="#/definitions/ImageFeatures")
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Image not found"
     *      ),
     *      @SWG\Response(
     *          response=500,
     *          description="Failed to extract image features"
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function extractFeatures($id, AIService $aiService)
    {
        $image = Image::find($id);

        if (!$image) {
            return $this->sendError('Image not found.', 404);
        }

        // The 'src' attribute should hold the path like 'storage/images/uploads/filename.jpg'
        // For the AIService, we might need a full path or a path relative to the storage/app directory.
        // Assuming AIService can handle the path as stored in 'src' or can derive it.
        // If AIService needs an absolute path, this might need adjustment: e.g., storage_path('app/public/' . str_replace('storage/', '', $image->src))
        $imagePath = $image->src;

        try {
            $features = $aiService->extractFeatures($imagePath);
            return $this->sendResponse($features, 'Image features extracted successfully.');
        } catch (\Exception $e) {
            // Log::error("Feature extraction failed for image ID {$id}: " . $e->getMessage());
            return $this->sendError('Failed to extract image features.', 500);
        }
    }

    /**
     * Upload a general image file.
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/images/upload_general",
     *      summary="Upload a general image file",
     *      tags={"Image"},
     *      security={{"jwt":{}}},
     *      consumes={"multipart/form-data"},
     *      @SWG\Parameter(
     *          name="image",
     *          in="formData",
     *          type="file",
     *          required=true,
     *          description="Image file to upload (jpeg, png, jpg, gif, svg)"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Image uploaded successfully",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", description="Image ID")
     *          )
     *      ),
     *      @SWG\Response(
     *          response=400,
     *          description="No image file uploaded"
     *      ),
     *      @SWG\Response(
     *          response=415,
     *          description="Invalid image type"
     *      ),
     *      @SWG\Response(
     *          response=500,
     *          description="Failed to save image"
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function uploadImageGeneral(Request $request)
    {
        if (!$request->hasFile('image')) {
            return $this->sendError('No image file uploaded.', 400);
        }

        $imageFile = $request->file('image');

        // Basic validation for image type (can be expanded)
        $allowedMimes = ['jpeg', 'png', 'jpg', 'gif', 'svg'];
        if (!in_array($imageFile->getClientOriginalExtension(), $allowedMimes)) {
            return $this->sendError('Invalid image type.', 415);
        }

        try {
            $date = time();
            $originalName = $imageFile->getClientOriginalName();
            $sanitizedOriginalName = $this->sanitize($originalName, true); // Sanitize for filename
            $filename = $date . '_' . $sanitizedOriginalName;

            // Store in storage/app/public/images/uploads
            $path = $imageFile->storeAs('public/images/uploads', $filename);

            if (!$path) {
                return $this->sendError('Failed to save image.', 500);
            }

            // Create database entry
            $imageId = DB::table('images')->insertGetId([
                'src' => 'storage/images/uploads/' . $filename, // Path accessible via symlink
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (!$imageId) {
                // Attempt to delete the stored file if DB insertion fails
                Storage::delete($path);
                return $this->sendError('Failed to create image record in database.', 500);
            }

            return $this->sendResponse(['id' => $imageId], 'Image uploaded successfully.');

        } catch (\Exception $e) {
            // Log the exception details (optional but recommended)
            // Log::error("Image upload failed: " . $e->getMessage());
            return $this->sendError('An unexpected error occurred during image upload.', 500);
        }
    }

    /**
     * Set an image as primary.
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/images/set_primary",
     *      summary="Set an image as primary",
     *      tags={"Image"},
     *      security={{"jwt":{}}},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          required=true,
     *          description="Image data",
     *          @SWG\Schema(
     *              type="object",
     *              required={"id"},
     *              @SWG\Property(property="id", type="integer", description="Image ID"),
     *              @SWG\Property(property="src", type="string", description="Image source path"),
     *              @SWG\Property(property="benefit_id", type="integer", description="Benefit ID"),
     *              @SWG\Property(property="store_id", type="integer", description="Store ID"),
     *              @SWG\Property(property="activity_id", type="integer", description="Activity ID"),
     *              @SWG\Property(property="event_id", type="integer", description="Event ID"),
     *              @SWG\Property(property="entity_id", type="integer", description="Entity ID")
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Image set as primary successfully",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/Image")
     *          )
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function set_primary(Request $request){

        $img = $request->all();

        Image::where('product_id', $img['product_id'])
            ->update(['primary' => 0]);

        Image::where('id', $img['id'])
            ->update(['primary' => 1]);
        return $this->sendResponse($img, 'Image set as primary successfully.');
    }


    function sanitize($string = '', $is_filename = FALSE)
    {
        // Replace all weird characters with dashes
        $string = preg_replace('/[^\w\-' . ($is_filename ? '~_' : '') . ']+/u', '-', $string);

        // Only allow one dash separator at a time (and make string lowercase)
        return mb_strtolower(preg_replace('/--+/u', '-', $string), 'UTF-8');
    }

}
