<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\StoreDiscount;

class BookingDiscountApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_booking_discount()
    {
        $bookingDiscount = StoreDiscount::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/booking_discounts', $bookingDiscount
        );

        $this->assertApiResponse($bookingDiscount);
    }

    /**
     * @test
     */
    public function test_read_booking_discount()
    {
        $bookingDiscount = StoreDiscount::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/booking_discounts/'.$bookingDiscount->id
        );

        $this->assertApiResponse($bookingDiscount->toArray());
    }

    /**
     * @test
     */
    public function test_update_booking_discount()
    {
        $bookingDiscount = StoreDiscount::factory()->create();
        $editedBookingDiscount = StoreDiscount::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/booking_discounts/'.$bookingDiscount->id,
            $editedBookingDiscount
        );

        $this->assertApiResponse($editedBookingDiscount);
    }

    /**
     * @test
     */
    public function test_delete_booking_discount()
    {
        $bookingDiscount = StoreDiscount::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/booking_discounts/'.$bookingDiscount->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/booking_discounts/'.$bookingDiscount->id
        );

        $this->response->assertStatus(404);
    }
}
