<?php namespace Tests\Repositories;

use App\Models\$City;
use App\Repositories\$CityRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class $CityRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var $CityRepository
     */
    protected $$CityRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->$CityRepo = \App::make($CityRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_$_city()
    {
        $$City = factory($City::class)->make()->toArray();

        $created$City = $this->$CityRepo->create($$City);

        $created$City = $created$City->toArray();
        $this->assertArrayHasKey('id', $created$City);
        $this->assertNotNull($created$City['id'], 'Created $City must have id specified');
        $this->assertNotNull($City::find($created$City['id']), '$City with given id must be in DB');
        $this->assertModelData($$City, $created$City);
    }

    /**
     * @test read
     */
    public function test_read_$_city()
    {
        $$City = factory($City::class)->create();

        $db$City = $this->$CityRepo->find($$City->id);

        $db$City = $db$City->toArray();
        $this->assertModelData($$City->toArray(), $db$City);
    }

    /**
     * @test update
     */
    public function test_update_$_city()
    {
        $$City = factory($City::class)->create();
        $fake$City = factory($City::class)->make()->toArray();

        $updated$City = $this->$CityRepo->update($fake$City, $$City->id);

        $this->assertModelData($fake$City, $updated$City->toArray());
        $db$City = $this->$CityRepo->find($$City->id);
        $this->assertModelData($fake$City, $db$City->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_$_city()
    {
        $$City = factory($City::class)->create();

        $resp = $this->$CityRepo->delete($$City->id);

        $this->assertTrue($resp);
        $this->assertNull($City::find($$City->id), '$City should not exist in DB');
    }
}
