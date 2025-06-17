<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\HotelBookingState;

class BookingStateApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_booking_state()
    {
        $bookingState = HotelBookingState::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/booking_states', $bookingState
        );

        $this->assertApiResponse($bookingState);
    }

    /**
     * @test
     */
    public function test_read_booking_state()
    {
        $bookingState = HotelBookingState::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/booking_states/'.$bookingState->id
        );

        $this->assertApiResponse($bookingState->toArray());
    }

    /**
     * @test
     */
    public function test_update_booking_state()
    {
        $bookingState = HotelBookingState::factory()->create();
        $editedBookingState = HotelBookingState::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/booking_states/'.$bookingState->id,
            $editedBookingState
        );

        $this->assertApiResponse($editedBookingState);
    }

    /**
     * @test
     */
    public function test_delete_booking_state()
    {
        $bookingState = HotelBookingState::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/booking_states/'.$bookingState->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/booking_states/'.$bookingState->id
        );

        $this->response->assertStatus(404);
    }
}
