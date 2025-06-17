<?php namespace Tests\Repositories;

use App\Models\Family;
use App\Repositories\FamilyRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FamilyRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FamilyRepository
     */
    protected $familyRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->familyRepo = \App::make(FamilyRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_family()
    {
        $family = factory(Family::class)->make()->toArray();

        $createdFamily = $this->familyRepo->create($family);

        $createdFamily = $createdFamily->toArray();
        $this->assertArrayHasKey('id', $createdFamily);
        $this->assertNotNull($createdFamily['id'], 'Created Family must have id specified');
        $this->assertNotNull(Family::find($createdFamily['id']), 'Family with given id must be in DB');
        $this->assertModelData($family, $createdFamily);
    }

    /**
     * @test read
     */
    public function test_read_family()
    {
        $family = factory(Family::class)->create();

        $dbFamily = $this->familyRepo->find($family->id);

        $dbFamily = $dbFamily->toArray();
        $this->assertModelData($family->toArray(), $dbFamily);
    }

    /**
     * @test update
     */
    public function test_update_family()
    {
        $family = factory(Family::class)->create();
        $fakeFamily = factory(Family::class)->make()->toArray();

        $updatedFamily = $this->familyRepo->update($fakeFamily, $family->id);

        $this->assertModelData($fakeFamily, $updatedFamily->toArray());
        $dbFamily = $this->familyRepo->find($family->id);
        $this->assertModelData($fakeFamily, $dbFamily->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_family()
    {
        $family = factory(Family::class)->create();

        $resp = $this->familyRepo->delete($family->id);

        $this->assertTrue($resp);
        $this->assertNull(Family::find($family->id), 'Family should not exist in DB');
    }
}
