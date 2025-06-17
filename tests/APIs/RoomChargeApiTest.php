<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\RoomCharge;

class RoomChargeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_room_charge()
    {
        $roomCharge = RoomCharge::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/room_charges', $roomCharge
        );

        $this->assertApiResponse($roomCharge);
    }

    /**
     * @test
     */
    public function test_read_room_charge()
    {
        $roomCharge = RoomCharge::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/room_charges/'.$roomCharge->id
        );

        $this->assertApiResponse($roomCharge->toArray());
    }

    /**
     * @test
     */
    public function test_update_room_charge()
    {
        $roomCharge = RoomCharge::factory()->create();
        $editedRoomCharge = RoomCharge::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/room_charges/'.$roomCharge->id,
            $editedRoomCharge
        );

        $this->assertApiResponse($editedRoomCharge);
    }

    /**
     * @test
     */
    public function test_delete_room_charge()
    {
        $roomCharge = RoomCharge::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/room_charges/'.$roomCharge->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/room_charges/'.$roomCharge->id
        );

        $this->response->assertStatus(404);
    }
}
