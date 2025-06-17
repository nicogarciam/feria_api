<?php namespace Tests\Repositories;

use App\Models\AccommodationPrice;
use App\Repositories\AccommodationPriceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AccommodationPriceRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AccommodationPriceRepository
     */
    protected $accommodationPriceRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->accommodationPriceRepo = \App::make(AccommodationPriceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_accommodation_price()
    {
        $accommodationPrice = AccommodationPrice::factory()->make()->toArray();

        $createdAccommodationPrice = $this->accommodationPriceRepo->create($accommodationPrice);

        $createdAccommodationPrice = $createdAccommodationPrice->toArray();
        $this->assertArrayHasKey('id', $createdAccommodationPrice);
        $this->assertNotNull($createdAccommodationPrice['id'], 'Created AccommodationPrice must have id specified');
        $this->assertNotNull(AccommodationPrice::find($createdAccommodationPrice['id']), 'AccommodationPrice with given id must be in DB');
        $this->assertModelData($accommodationPrice, $createdAccommodationPrice);
    }

    /**
     * @test read
     */
    public function test_read_accommodation_price()
    {
        $accommodationPrice = AccommodationPrice::factory()->create();

        $dbAccommodationPrice = $this->accommodationPriceRepo->find($accommodationPrice->id);

        $dbAccommodationPrice = $dbAccommodationPrice->toArray();
        $this->assertModelData($accommodationPrice->toArray(), $dbAccommodationPrice);
    }

    /**
     * @test update
     */
    public function test_update_accommodation_price()
    {
        $accommodationPrice = AccommodationPrice::factory()->create();
        $fakeAccommodationPrice = AccommodationPrice::factory()->make()->toArray();

        $updatedAccommodationPrice = $this->accommodationPriceRepo->update($fakeAccommodationPrice, $accommodationPrice->id);

        $this->assertModelData($fakeAccommodationPrice, $updatedAccommodationPrice->toArray());
        $dbAccommodationPrice = $this->accommodationPriceRepo->find($accommodationPrice->id);
        $this->assertModelData($fakeAccommodationPrice, $dbAccommodationPrice->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_accommodation_price()
    {
        $accommodationPrice = AccommodationPrice::factory()->create();

        $resp = $this->accommodationPriceRepo->delete($accommodationPrice->id);

        $this->assertTrue($resp);
        $this->assertNull(AccommodationPrice::find($accommodationPrice->id), 'AccommodationPrice should not exist in DB');
    }
}
