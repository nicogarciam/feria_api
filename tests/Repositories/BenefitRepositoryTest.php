<?php namespace Tests\Repositories;

use App\Models\Benefit;
use App\Repositories\BenefitRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class BenefitRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var BenefitRepository
     */
    protected $benefitRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->benefitRepo = \App::make(BenefitRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_benefit()
    {
        $benefit = factory(Benefit::class)->make()->toArray();

        $createdBenefit = $this->benefitRepo->create($benefit);

        $createdBenefit = $createdBenefit->toArray();
        $this->assertArrayHasKey('id', $createdBenefit);
        $this->assertNotNull($createdBenefit['id'], 'Created Benefit must have id specified');
        $this->assertNotNull(Benefit::find($createdBenefit['id']), 'Benefit with given id must be in DB');
        $this->assertModelData($benefit, $createdBenefit);
    }

    /**
     * @test read
     */
    public function test_read_benefit()
    {
        $benefit = factory(Benefit::class)->create();

        $dbBenefit = $this->benefitRepo->find($benefit->id);

        $dbBenefit = $dbBenefit->toArray();
        $this->assertModelData($benefit->toArray(), $dbBenefit);
    }

    /**
     * @test update
     */
    public function test_update_benefit()
    {
        $benefit = factory(Benefit::class)->create();
        $fakeBenefit = factory(Benefit::class)->make()->toArray();

        $updatedBenefit = $this->benefitRepo->update($fakeBenefit, $benefit->id);

        $this->assertModelData($fakeBenefit, $updatedBenefit->toArray());
        $dbBenefit = $this->benefitRepo->find($benefit->id);
        $this->assertModelData($fakeBenefit, $dbBenefit->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_benefit()
    {
        $benefit = factory(Benefit::class)->create();

        $resp = $this->benefitRepo->delete($benefit->id);

        $this->assertTrue($resp);
        $this->assertNull(Benefit::find($benefit->id), 'Benefit should not exist in DB');
    }
}
