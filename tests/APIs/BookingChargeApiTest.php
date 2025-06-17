<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\BookingCharge;

class BookingChargeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_booking_charge()
    {
        $bookingCharge = BookingCharge::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/booking_charges', $bookingCharge
        );

        $this->assertApiResponse($bookingCharge);
    }

    /**
     * @test
     */
    public function test_read_booking_charge()
    {
        $bookingCharge = BookingCharge::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/booking_charges/'.$bookingCharge->id
        );

        $this->assertApiResponse($bookingCharge->toArray());
    }

    /**
     * @test
     */
    public function test_update_booking_charge()
    {
        $bookingCharge = BookingCharge::factory()->create();
        $editedBookingCharge = BookingCharge::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/booking_charges/'.$bookingCharge->id,
            $editedBookingCharge
        );

        $this->assertApiResponse($editedBookingCharge);
    }

    /**
     * @test
     */
    public function test_delete_booking_charge()
    {
        $bookingCharge = BookingCharge::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/booking_charges/'.$bookingCharge->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/booking_charges/'.$bookingCharge->id
        );

        $this->response->assertStatus(404);
    }
}
