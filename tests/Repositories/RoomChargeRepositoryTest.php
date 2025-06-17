<?php namespace Tests\Repositories;

use App\Models\RoomCharge;
use App\Repositories\RoomChargeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class RoomChargeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var RoomChargeRepository
     */
    protected $roomChargeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->roomChargeRepo = \App::make(RoomChargeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_room_charge()
    {
        $roomCharge = RoomCharge::factory()->make()->toArray();

        $createdRoomCharge = $this->roomChargeRepo->create($roomCharge);

        $createdRoomCharge = $createdRoomCharge->toArray();
        $this->assertArrayHasKey('id', $createdRoomCharge);
        $this->assertNotNull($createdRoomCharge['id'], 'Created RoomCharge must have id specified');
        $this->assertNotNull(RoomCharge::find($createdRoomCharge['id']), 'RoomCharge with given id must be in DB');
        $this->assertModelData($roomCharge, $createdRoomCharge);
    }

    /**
     * @test read
     */
    public function test_read_room_charge()
    {
        $roomCharge = RoomCharge::factory()->create();

        $dbRoomCharge = $this->roomChargeRepo->find($roomCharge->id);

        $dbRoomCharge = $dbRoomCharge->toArray();
        $this->assertModelData($roomCharge->toArray(), $dbRoomCharge);
    }

    /**
     * @test update
     */
    public function test_update_room_charge()
    {
        $roomCharge = RoomCharge::factory()->create();
        $fakeRoomCharge = RoomCharge::factory()->make()->toArray();

        $updatedRoomCharge = $this->roomChargeRepo->update($fakeRoomCharge, $roomCharge->id);

        $this->assertModelData($fakeRoomCharge, $updatedRoomCharge->toArray());
        $dbRoomCharge = $this->roomChargeRepo->find($roomCharge->id);
        $this->assertModelData($fakeRoomCharge, $dbRoomCharge->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_room_charge()
    {
        $roomCharge = RoomCharge::factory()->create();

        $resp = $this->roomChargeRepo->delete($roomCharge->id);

        $this->assertTrue($resp);
        $this->assertNull(RoomCharge::find($roomCharge->id), 'RoomCharge should not exist in DB');
    }
}
