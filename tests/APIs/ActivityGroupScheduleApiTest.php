<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ActivityGroupSchedule;

class ActivityGroupScheduleApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_activity_group_schedule()
    {
        $activityGroupSchedule = factory(ActivityGroupSchedule::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/activity_group_schedules', $activityGroupSchedule
        );

        $this->assertApiResponse($activityGroupSchedule);
    }

    /**
     * @test
     */
    public function test_read_activity_group_schedule()
    {
        $activityGroupSchedule = factory(ActivityGroupSchedule::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/activity_group_schedules/'.$activityGroupSchedule->id
        );

        $this->assertApiResponse($activityGroupSchedule->toArray());
    }

    /**
     * @test
     */
    public function test_update_activity_group_schedule()
    {
        $activityGroupSchedule = factory(ActivityGroupSchedule::class)->create();
        $editedActivityGroupSchedule = factory(ActivityGroupSchedule::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/activity_group_schedules/'.$activityGroupSchedule->id,
            $editedActivityGroupSchedule
        );

        $this->assertApiResponse($editedActivityGroupSchedule);
    }

    /**
     * @test
     */
    public function test_delete_activity_group_schedule()
    {
        $activityGroupSchedule = factory(ActivityGroupSchedule::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/activity_group_schedules/'.$activityGroupSchedule->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/activity_group_schedules/'.$activityGroupSchedule->id
        );

        $this->response->assertStatus(404);
    }
}
