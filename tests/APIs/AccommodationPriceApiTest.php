<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AccommodationPrice;

class AccommodationPriceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_accommodation_price()
    {
        $accommodationPrice = AccommodationPrice::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/accommodation_prices', $accommodationPrice
        );

        $this->assertApiResponse($accommodationPrice);
    }

    /**
     * @test
     */
    public function test_read_accommodation_price()
    {
        $accommodationPrice = AccommodationPrice::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/accommodation_prices/'.$accommodationPrice->id
        );

        $this->assertApiResponse($accommodationPrice->toArray());
    }

    /**
     * @test
     */
    public function test_update_accommodation_price()
    {
        $accommodationPrice = AccommodationPrice::factory()->create();
        $editedAccommodationPrice = AccommodationPrice::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/accommodation_prices/'.$accommodationPrice->id,
            $editedAccommodationPrice
        );

        $this->assertApiResponse($editedAccommodationPrice);
    }

    /**
     * @test
     */
    public function test_delete_accommodation_price()
    {
        $accommodationPrice = AccommodationPrice::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/accommodation_prices/'.$accommodationPrice->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/accommodation_prices/'.$accommodationPrice->id
        );

        $this->response->assertStatus(404);
    }
}
