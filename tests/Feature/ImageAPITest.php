<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Account; // Assuming Account model is used for authentication
use Illuminate\Http\UploadedFile;
use Tymon\JWTAuth\Facades\JWTAuth; // For JWT authentication
use Illuminate\Support\Facades\Storage; // For file storage assertions
use App\Models\Image; // For creating Image model instances
use Illuminate\Support\Facades\Http; // For mocking HTTP calls

class ImageAPITest extends TestCase
{
    use RefreshDatabase; // Resets database for each test
    use WithFaker;

    protected $authenticatedUser;
    protected $token;

    /**
     * Set up the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create a user for authentication
        $this->authenticatedUser = Account::factory()->create([
            'password' => bcrypt('password123'), // Set a known password
        ]);

        // Generate a JWT token for the user
        $this->token = JWTAuth::fromUser($this->authenticatedUser);
    }

    /**
     * Placeholder test for general image upload.
     *
     * @return void
     */
    public function testUploadImageGeneral()
    {
        Storage::fake('public'); // Use the 'public' disk and fake it

        $file = UploadedFile::fake()->image('test_avatar.jpg');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/images/upload_general', [
            'image' => $file,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Image uploaded successfully.',
            ])
            ->assertJsonStructure([
                'success',
                'data' => ['id'],
                'message',
            ]);

        $imageId = $response->json('data.id');
        $this->assertDatabaseHas('images', ['id' => $imageId]);

        // Retrieve the image model to get the filename
        $imageModel = Image::find($imageId);
        Storage::disk('public')->assertExists('images/uploads/' . basename($imageModel->src));
    }

    /**
     * Test for image feature extraction.
     *
     * @return void
     */
    public function testExtractFeatures()
    {
        Storage::fake('public');
        $fakeImageContent = 'fake image data'; // Content doesn't matter for mock
        $imageFileName = 'test_image_for_features.jpg';
        $imageStoragePath = 'images/uploads/' . $imageFileName; // Path relative to public disk
        Storage::disk('public')->put($imageStoragePath, $fakeImageContent);

        $image = Image::create([
            'src' => 'storage/' . $imageStoragePath, // Path as stored by ImageAPIController
            // 'title' => 'Test Image for Feature Extraction', // Optional
            // 'account_id' => $this->authenticatedUser->id, // If needed
        ]);

        // Mocked Gemini Vision API response
        $mockedVisionResponseJsonString = json_encode([
            'color' => 'red',
            'type' => 'dress',
            'condition' => 'good',
        ]);

        Http::fake([
            'generativelanguage.googleapis.com/v1beta/models/gemini-pro-vision:generateContent*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => $mockedVisionResponseJsonString]
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson("/api/images/{$image->id}/extract_features");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => [
                         'color' => 'red',
                         'type' => 'dress',
                         'condition' => 'good',
                         'estimation_basis' => 'gemini_vision_api'
                     ],
                     'message' => 'Image features extracted successfully.'
                 ]);

        Http::assertSent(function ($request) {
            return Str::contains($request->url(), 'gemini-pro-vision:generateContent');
        });
    }

    /**
     * Test for suggesting a price for an image.
     *
     * @return void
     */
    public function testSuggestPriceForImage()
    {
        Storage::fake('public');
        $fakeImageContent = 'fake image data for pricing';
        $imageFileName = 'test_image_for_pricing.jpg';
        $imageStoragePath = 'images/uploads/' . $imageFileName;
        Storage::disk('public')->put($imageStoragePath, $fakeImageContent);

        $image = Image::create([
            'src' => 'storage/' . $imageStoragePath, // Path as stored by ImageAPIController
            // 'title' => 'Test Garment for Pricing', // Optional
            // 'account_id' => $this->authenticatedUser->id, // If needed
        ]);

        // Mocked Gemini Vision API response for feature extraction part
        $mockedVisionResponseJsonString = json_encode([
            'color' => 'green',
            'type' => 'pants',
            'condition' => 'fair',
        ]);

        // Mocked Gemini Text API response for price suggestion part
        $mockedPriceResponseJsonString = json_encode([
            'min_price' => 75,
            'max_price' => 125,
            'currency' => 'EUR',
        ]);

        Http::fake([
            'generativelanguage.googleapis.com/v1beta/models/gemini-pro-vision:generateContent*' => Http::response([
                'candidates' => [['content' => ['parts' => [['text' => $mockedVisionResponseJsonString]]]]]
            ], 200),
            'generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent*' => Http::response([
                'candidates' => [['content' => ['parts' => [['text' => $mockedPriceResponseJsonString]]]]]
            ], 200)
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson("/api/images/{$image->id}/suggest_price");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => [
                         'min_price' => 75,
                         'max_price' => 125,
                         'currency' => 'EUR',
                         'estimation_basis' => 'gemini_api'
                     ],
                     'message' => 'Price suggestion retrieved successfully.'
                 ]);

        // Assert that both mocked endpoints were called
        Http::assertSent(function ($request) {
            return Str::contains($request->url(), 'gemini-pro-vision:generateContent');
        });
        Http::assertSent(function ($request) {
            return Str::contains($request->url(), 'gemini-pro:generateContent') && !Str::contains($request->url(), 'gemini-pro-vision:generateContent');
        });
    }
}
