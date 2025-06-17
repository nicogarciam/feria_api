<?php namespace Tests\Repositories;

use App\Models\StoreDiscount;
use App\Repositories\BookingDiscountRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class BookingDiscountRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var BookingDiscountRepository
     */
    protected $bookingDiscountRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->bookingDiscountRepo = \App::make(BookingDiscountRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_booking_discount()
    {
        $bookingDiscount = StoreDiscount::factory()->make()->toArray();

        $createdBookingDiscount = $this->bookingDiscountRepo->create($bookingDiscount);

        $createdBookingDiscount = $createdBookingDiscount->toArray();
        $this->assertArrayHasKey('id', $createdBookingDiscount);
        $this->assertNotNull($createdBookingDiscount['id'], 'Created StoreDiscount must have id specified');
        $this->assertNotNull(StoreDiscount::find($createdBookingDiscount['id']), 'StoreDiscount with given id must be in DB');
        $this->assertModelData($bookingDiscount, $createdBookingDiscount);
    }

    /**
     * @test read
     */
    public function test_read_booking_discount()
    {
        $bookingDiscount = StoreDiscount::factory()->create();

        $dbBookingDiscount = $this->bookingDiscountRepo->find($bookingDiscount->id);

        $dbBookingDiscount = $dbBookingDiscount->toArray();
        $this->assertModelData($bookingDiscount->toArray(), $dbBookingDiscount);
    }

    /**
     * @test update
     */
    public function test_update_booking_discount()
    {
        $bookingDiscount = StoreDiscount::factory()->create();
        $fakeBookingDiscount = StoreDiscount::factory()->make()->toArray();

        $updatedBookingDiscount = $this->bookingDiscountRepo->update($fakeBookingDiscount, $bookingDiscount->id);

        $this->assertModelData($fakeBookingDiscount, $updatedBookingDiscount->toArray());
        $dbBookingDiscount = $this->bookingDiscountRepo->find($bookingDiscount->id);
        $this->assertModelData($fakeBookingDiscount, $dbBookingDiscount->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_booking_discount()
    {
        $bookingDiscount = StoreDiscount::factory()->create();

        $resp = $this->bookingDiscountRepo->delete($bookingDiscount->id);

        $this->assertTrue($resp);
        $this->assertNull(StoreDiscount::find($bookingDiscount->id), 'StoreDiscount should not exist in DB');
    }
}
