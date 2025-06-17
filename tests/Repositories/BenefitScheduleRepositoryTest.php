<?php namespace Tests\Repositories;

use App\Models\BenefitSchedule;
use App\Repositories\BenefitScheduleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class BenefitScheduleRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var BenefitScheduleRepository
     */
    protected $benefitScheduleRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->benefitScheduleRepo = \App::make(BenefitScheduleRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_benefit_schedule()
    {
        $benefitSchedule = factory(BenefitSchedule::class)->make()->toArray();

        $createdBenefitSchedule = $this->benefitScheduleRepo->create($benefitSchedule);

        $createdBenefitSchedule = $createdBenefitSchedule->toArray();
        $this->assertArrayHasKey('id', $createdBenefitSchedule);
        $this->assertNotNull($createdBenefitSchedule['id'], 'Created BenefitSchedule must have id specified');
        $this->assertNotNull(BenefitSchedule::find($createdBenefitSchedule['id']), 'BenefitSchedule with given id must be in DB');
        $this->assertModelData($benefitSchedule, $createdBenefitSchedule);
    }

    /**
     * @test read
     */
    public function test_read_benefit_schedule()
    {
        $benefitSchedule = factory(BenefitSchedule::class)->create();

        $dbBenefitSchedule = $this->benefitScheduleRepo->find($benefitSchedule->id);

        $dbBenefitSchedule = $dbBenefitSchedule->toArray();
        $this->assertModelData($benefitSchedule->toArray(), $dbBenefitSchedule);
    }

    /**
     * @test update
     */
    public function test_update_benefit_schedule()
    {
        $benefitSchedule = factory(BenefitSchedule::class)->create();
        $fakeBenefitSchedule = factory(BenefitSchedule::class)->make()->toArray();

        $updatedBenefitSchedule = $this->benefitScheduleRepo->update($fakeBenefitSchedule, $benefitSchedule->id);

        $this->assertModelData($fakeBenefitSchedule, $updatedBenefitSchedule->toArray());
        $dbBenefitSchedule = $this->benefitScheduleRepo->find($benefitSchedule->id);
        $this->assertModelData($fakeBenefitSchedule, $dbBenefitSchedule->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_benefit_schedule()
    {
        $benefitSchedule = factory(BenefitSchedule::class)->create();

        $resp = $this->benefitScheduleRepo->delete($benefitSchedule->id);

        $this->assertTrue($resp);
        $this->assertNull(BenefitSchedule::find($benefitSchedule->id), 'BenefitSchedule should not exist in DB');
    }
}
