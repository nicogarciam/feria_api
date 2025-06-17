<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Category;

class AccommodationTypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_accommodation_type()
    {
        $accommodationType = Category::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/accommodation_types', $accommodationType
        );

        $this->assertApiResponse($accommodationType);
    }

    /**
     * @test
     */
    public function test_read_accommodation_type()
    {
        $accommodationType = Category::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/accommodation_types/'.$accommodationType->id
        );

        $this->assertApiResponse($accommodationType->toArray());
    }

    /**
     * @test
     */
    public function test_update_accommodation_type()
    {
        $accommodationType = Category::factory()->create();
        $editedAccommodationType = Category::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/accommodation_types/'.$accommodationType->id,
            $editedAccommodationType
        );

        $this->assertApiResponse($editedAccommodationType);
    }

    /**
     * @test
     */
    public function test_delete_accommodation_type()
    {
        $accommodationType = Category::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/accommodation_types/'.$accommodationType->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/accommodation_types/'.$accommodationType->id
        );

        $this->response->assertStatus(404);
    }
}
