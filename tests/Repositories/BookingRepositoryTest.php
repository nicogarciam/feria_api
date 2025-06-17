<?php namespace Tests\Repositories;

use App\Models\Sale;
use App\Repositories\SaleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class BookingRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SaleRepository
     */
    protected $bookingRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->bookingRepo = \App::make(SaleRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_booking()
    {
        $booking = Sale::factory()->make()->toArray();

        $createdBooking = $this->bookingRepo->create($booking);

        $createdBooking = $createdBooking->toArray();
        $this->assertArrayHasKey('id', $createdBooking);
        $this->assertNotNull($createdBooking['id'], 'Created Sale must have id specified');
        $this->assertNotNull(Sale::find($createdBooking['id']), 'Sale with given id must be in DB');
        $this->assertModelData($booking, $createdBooking);
    }

    /**
     * @test read
     */
    public function test_read_booking()
    {
        $booking = Sale::factory()->create();

        $dbBooking = $this->bookingRepo->find($booking->id);

        $dbBooking = $dbBooking->toArray();
        $this->assertModelData($booking->toArray(), $dbBooking);
    }

    /**
     * @test update
     */
    public function test_update_booking()
    {
        $booking = Sale::factory()->create();
        $fakeBooking = Sale::factory()->make()->toArray();

        $updatedBooking = $this->bookingRepo->update($fakeBooking, $booking->id);

        $this->assertModelData($fakeBooking, $updatedBooking->toArray());
        $dbBooking = $this->bookingRepo->find($booking->id);
        $this->assertModelData($fakeBooking, $dbBooking->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_booking()
    {
        $booking = Sale::factory()->create();

        $resp = $this->bookingRepo->delete($booking->id);

        $this->assertTrue($resp);
        $this->assertNull(Sale::find($booking->id), 'Sale should not exist in DB');
    }
}
