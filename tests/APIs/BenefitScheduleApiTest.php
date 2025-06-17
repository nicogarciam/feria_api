<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\BenefitSchedule;

class BenefitScheduleApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_benefit_schedule()
    {
        $benefitSchedule = factory(BenefitSchedule::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/benefit_schedules', $benefitSchedule
        );

        $this->assertApiResponse($benefitSchedule);
    }

    /**
     * @test
     */
    public function test_read_benefit_schedule()
    {
        $benefitSchedule = factory(BenefitSchedule::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/benefit_schedules/'.$benefitSchedule->id
        );

        $this->assertApiResponse($benefitSchedule->toArray());
    }

    /**
     * @test
     */
    public function test_update_benefit_schedule()
    {
        $benefitSchedule = factory(BenefitSchedule::class)->create();
        $editedBenefitSchedule = factory(BenefitSchedule::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/benefit_schedules/'.$benefitSchedule->id,
            $editedBenefitSchedule
        );

        $this->assertApiResponse($editedBenefitSchedule);
    }

    /**
     * @test
     */
    public function test_delete_benefit_schedule()
    {
        $benefitSchedule = factory(BenefitSchedule::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/benefit_schedules/'.$benefitSchedule->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/benefit_schedules/'.$benefitSchedule->id
        );

        $this->response->assertStatus(404);
    }
}
