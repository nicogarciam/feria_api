<?php namespace Tests\Repositories;

use App\Models\Store;
use App\Repositories\StoreRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class HotelRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var StoreRepository
     */
    protected $hotelRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->hotelRepo = \App::make(StoreRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_hotel()
    {
        $hotel = Store::factory()->make()->toArray();

        $createdHotel = $this->hotelRepo->create($hotel);

        $createdHotel = $createdHotel->toArray();
        $this->assertArrayHasKey('id', $createdHotel);
        $this->assertNotNull($createdHotel['id'], 'Created Store must have id specified');
        $this->assertNotNull(Store::find($createdHotel['id']), 'Store with given id must be in DB');
        $this->assertModelData($hotel, $createdHotel);
    }

    /**
     * @test read
     */
    public function test_read_hotel()
    {
        $hotel = Store::factory()->create();

        $dbHotel = $this->hotelRepo->find($hotel->id);

        $dbHotel = $dbHotel->toArray();
        $this->assertModelData($hotel->toArray(), $dbHotel);
    }

    /**
     * @test update
     */
    public function test_update_hotel()
    {
        $hotel = Store::factory()->create();
        $fakeHotel = Store::factory()->make()->toArray();

        $updatedHotel = $this->hotelRepo->update($fakeHotel, $hotel->id);

        $this->assertModelData($fakeHotel, $updatedHotel->toArray());
        $dbHotel = $this->hotelRepo->find($hotel->id);
        $this->assertModelData($fakeHotel, $dbHotel->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_hotel()
    {
        $hotel = Store::factory()->create();

        $resp = $this->hotelRepo->delete($hotel->id);

        $this->assertTrue($resp);
        $this->assertNull(Store::find($hotel->id), 'Store should not exist in DB');
    }
}
