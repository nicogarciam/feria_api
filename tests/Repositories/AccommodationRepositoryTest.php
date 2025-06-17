<?php namespace Tests\Repositories;

use App\Models\Accommodation;
use App\Repositories\ProductRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AccommodationRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ProductRepository
     */
    protected $accommodationRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->accommodationRepo = \App::make(ProductRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_accommodation()
    {
        $accommodation = Accommodation::factory()->make()->toArray();

        $createdAccommodation = $this->accommodationRepo->create($accommodation);

        $createdAccommodation = $createdAccommodation->toArray();
        $this->assertArrayHasKey('id', $createdAccommodation);
        $this->assertNotNull($createdAccommodation['id'], 'Created Accommodation must have id specified');
        $this->assertNotNull(Accommodation::find($createdAccommodation['id']), 'Accommodation with given id must be in DB');
        $this->assertModelData($accommodation, $createdAccommodation);
    }

    /**
     * @test read
     */
    public function test_read_accommodation()
    {
        $accommodation = Accommodation::factory()->create();

        $dbAccommodation = $this->accommodationRepo->find($accommodation->id);

        $dbAccommodation = $dbAccommodation->toArray();
        $this->assertModelData($accommodation->toArray(), $dbAccommodation);
    }

    /**
     * @test update
     */
    public function test_update_accommodation()
    {
        $accommodation = Accommodation::factory()->create();
        $fakeAccommodation = Accommodation::factory()->make()->toArray();

        $updatedAccommodation = $this->accommodationRepo->update($fakeAccommodation, $accommodation->id);

        $this->assertModelData($fakeAccommodation, $updatedAccommodation->toArray());
        $dbAccommodation = $this->accommodationRepo->find($accommodation->id);
        $this->assertModelData($fakeAccommodation, $dbAccommodation->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_accommodation()
    {
        $accommodation = Accommodation::factory()->create();

        $resp = $this->accommodationRepo->delete($accommodation->id);

        $this->assertTrue($resp);
        $this->assertNull(Accommodation::find($accommodation->id), 'Accommodation should not exist in DB');
    }
}
