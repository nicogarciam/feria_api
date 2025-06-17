<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Accommodation;

class AccommodationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_accommodation()
    {
        $accommodation = Accommodation::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/accommodations', $accommodation
        );

        $this->assertApiResponse($accommodation);
    }

    /**
     * @test
     */
    public function test_read_accommodation()
    {
        $accommodation = Accommodation::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/accommodations/'.$accommodation->id
        );

        $this->assertApiResponse($accommodation->toArray());
    }

    /**
     * @test
     */
    public function test_update_accommodation()
    {
        $accommodation = Accommodation::factory()->create();
        $editedAccommodation = Accommodation::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/accommodations/'.$accommodation->id,
            $editedAccommodation
        );

        $this->assertApiResponse($editedAccommodation);
    }

    /**
     * @test
     */
    public function test_delete_accommodation()
    {
        $accommodation = Accommodation::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/accommodations/'.$accommodation->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/accommodations/'.$accommodation->id
        );

        $this->response->assertStatus(404);
    }
}
