<?php namespace Tests\Repositories;

use App\Models\HotelBookingState;
use App\Repositories\SaleStateRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class BookingStateRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SaleStateRepository
     */
    protected $bookingStateRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->bookingStateRepo = \App::make(SaleStateRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_booking_state()
    {
        $bookingState = HotelBookingState::factory()->make()->toArray();

        $createdBookingState = $this->bookingStateRepo->create($bookingState);

        $createdBookingState = $createdBookingState->toArray();
        $this->assertArrayHasKey('id', $createdBookingState);
        $this->assertNotNull($createdBookingState['id'], 'Created HotelBookingState must have id specified');
        $this->assertNotNull(HotelBookingState::find($createdBookingState['id']), 'HotelBookingState with given id must be in DB');
        $this->assertModelData($bookingState, $createdBookingState);
    }

    /**
     * @test read
     */
    public function test_read_booking_state()
    {
        $bookingState = HotelBookingState::factory()->create();

        $dbBookingState = $this->bookingStateRepo->find($bookingState->id);

        $dbBookingState = $dbBookingState->toArray();
        $this->assertModelData($bookingState->toArray(), $dbBookingState);
    }

    /**
     * @test update
     */
    public function test_update_booking_state()
    {
        $bookingState = HotelBookingState::factory()->create();
        $fakeBookingState = HotelBookingState::factory()->make()->toArray();

        $updatedBookingState = $this->bookingStateRepo->update($fakeBookingState, $bookingState->id);

        $this->assertModelData($fakeBookingState, $updatedBookingState->toArray());
        $dbBookingState = $this->bookingStateRepo->find($bookingState->id);
        $this->assertModelData($fakeBookingState, $dbBookingState->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_booking_state()
    {
        $bookingState = HotelBookingState::factory()->create();

        $resp = $this->bookingStateRepo->delete($bookingState->id);

        $this->assertTrue($resp);
        $this->assertNull(HotelBookingState::find($bookingState->id), 'HotelBookingState should not exist in DB');
    }
}
