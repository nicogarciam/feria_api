<?php namespace Tests\Repositories;

use App\Models\BenefitPlaces;
use App\Repositories\BenefitPlacesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class BenefitPlacesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var BenefitPlacesRepository
     */
    protected $benefitPlacesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->benefitPlacesRepo = \App::make(BenefitPlacesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_benefit_places()
    {
        $benefitPlaces = factory(BenefitPlaces::class)->make()->toArray();

        $createdBenefitPlaces = $this->benefitPlacesRepo->create($benefitPlaces);

        $createdBenefitPlaces = $createdBenefitPlaces->toArray();
        $this->assertArrayHasKey('id', $createdBenefitPlaces);
        $this->assertNotNull($createdBenefitPlaces['id'], 'Created BenefitPlaces must have id specified');
        $this->assertNotNull(BenefitPlaces::find($createdBenefitPlaces['id']), 'BenefitPlaces with given id must be in DB');
        $this->assertModelData($benefitPlaces, $createdBenefitPlaces);
    }

    /**
     * @test read
     */
    public function test_read_benefit_places()
    {
        $benefitPlaces = factory(BenefitPlaces::class)->create();

        $dbBenefitPlaces = $this->benefitPlacesRepo->find($benefitPlaces->id);

        $dbBenefitPlaces = $dbBenefitPlaces->toArray();
        $this->assertModelData($benefitPlaces->toArray(), $dbBenefitPlaces);
    }

    /**
     * @test update
     */
    public function test_update_benefit_places()
    {
        $benefitPlaces = factory(BenefitPlaces::class)->create();
        $fakeBenefitPlaces = factory(BenefitPlaces::class)->make()->toArray();

        $updatedBenefitPlaces = $this->benefitPlacesRepo->update($fakeBenefitPlaces, $benefitPlaces->id);

        $this->assertModelData($fakeBenefitPlaces, $updatedBenefitPlaces->toArray());
        $dbBenefitPlaces = $this->benefitPlacesRepo->find($benefitPlaces->id);
        $this->assertModelData($fakeBenefitPlaces, $dbBenefitPlaces->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_benefit_places()
    {
        $benefitPlaces = factory(BenefitPlaces::class)->create();

        $resp = $this->benefitPlacesRepo->delete($benefitPlaces->id);

        $this->assertTrue($resp);
        $this->assertNull(BenefitPlaces::find($benefitPlaces->id), 'BenefitPlaces should not exist in DB');
    }
}
