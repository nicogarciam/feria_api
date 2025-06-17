<?php namespace Tests\Repositories;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AccommodationTypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CategoryRepository
     */
    protected $accommodationTypeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->accommodationTypeRepo = \App::make(CategoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_accommodation_type()
    {
        $accommodationType = Category::factory()->make()->toArray();

        $createdAccommodationType = $this->accommodationTypeRepo->create($accommodationType);

        $createdAccommodationType = $createdAccommodationType->toArray();
        $this->assertArrayHasKey('id', $createdAccommodationType);
        $this->assertNotNull($createdAccommodationType['id'], 'Created Category must have id specified');
        $this->assertNotNull(Category::find($createdAccommodationType['id']), 'Category with given id must be in DB');
        $this->assertModelData($accommodationType, $createdAccommodationType);
    }

    /**
     * @test read
     */
    public function test_read_accommodation_type()
    {
        $accommodationType = Category::factory()->create();

        $dbAccommodationType = $this->accommodationTypeRepo->find($accommodationType->id);

        $dbAccommodationType = $dbAccommodationType->toArray();
        $this->assertModelData($accommodationType->toArray(), $dbAccommodationType);
    }

    /**
     * @test update
     */
    public function test_update_accommodation_type()
    {
        $accommodationType = Category::factory()->create();
        $fakeAccommodationType = Category::factory()->make()->toArray();

        $updatedAccommodationType = $this->accommodationTypeRepo->update($fakeAccommodationType, $accommodationType->id);

        $this->assertModelData($fakeAccommodationType, $updatedAccommodationType->toArray());
        $dbAccommodationType = $this->accommodationTypeRepo->find($accommodationType->id);
        $this->assertModelData($fakeAccommodationType, $dbAccommodationType->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_accommodation_type()
    {
        $accommodationType = Category::factory()->create();

        $resp = $this->accommodationTypeRepo->delete($accommodationType->id);

        $this->assertTrue($resp);
        $this->assertNull(Category::find($accommodationType->id), 'Category should not exist in DB');
    }
}
