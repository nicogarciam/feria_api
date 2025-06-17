<?php namespace Tests\Repositories;

use App\Models\BookingCharge;
use App\Repositories\BookingChargeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class BookingChargeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var BookingChargeRepository
     */
    protected $bookingChargeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->bookingChargeRepo = \App::make(BookingChargeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_booking_charge()
    {
        $bookingCharge = BookingCharge::factory()->make()->toArray();

        $createdBookingCharge = $this->bookingChargeRepo->create($bookingCharge);

        $createdBookingCharge = $createdBookingCharge->toArray();
        $this->assertArrayHasKey('id', $createdBookingCharge);
        $this->assertNotNull($createdBookingCharge['id'], 'Created BookingCharge must have id specified');
        $this->assertNotNull(BookingCharge::find($createdBookingCharge['id']), 'BookingCharge with given id must be in DB');
        $this->assertModelData($bookingCharge, $createdBookingCharge);
    }

    /**
     * @test read
     */
    public function test_read_booking_charge()
    {
        $bookingCharge = BookingCharge::factory()->create();

        $dbBookingCharge = $this->bookingChargeRepo->find($bookingCharge->id);

        $dbBookingCharge = $dbBookingCharge->toArray();
        $this->assertModelData($bookingCharge->toArray(), $dbBookingCharge);
    }

    /**
     * @test update
     */
    public function test_update_booking_charge()
    {
        $bookingCharge = BookingCharge::factory()->create();
        $fakeBookingCharge = BookingCharge::factory()->make()->toArray();

        $updatedBookingCharge = $this->bookingChargeRepo->update($fakeBookingCharge, $bookingCharge->id);

        $this->assertModelData($fakeBookingCharge, $updatedBookingCharge->toArray());
        $dbBookingCharge = $this->bookingChargeRepo->find($bookingCharge->id);
        $this->assertModelData($fakeBookingCharge, $dbBookingCharge->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_booking_charge()
    {
        $bookingCharge = BookingCharge::factory()->create();

        $resp = $this->bookingChargeRepo->delete($bookingCharge->id);

        $this->assertTrue($resp);
        $this->assertNull(BookingCharge::find($bookingCharge->id), 'BookingCharge should not exist in DB');
    }
}
