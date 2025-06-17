<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ActivityGroup;

class ActivityGroupApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_activity_group()
    {
        $activityGroup = factory(ActivityGroup::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/activity_groups', $activityGroup
        );

        $this->assertApiResponse($activityGroup);
    }

    /**
     * @test
     */
    public function test_read_activity_group()
    {
        $activityGroup = factory(ActivityGroup::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/activity_groups/'.$activityGroup->id
        );

        $this->assertApiResponse($activityGroup->toArray());
    }

    /**
     * @test
     */
    public function test_update_activity_group()
    {
        $activityGroup = factory(ActivityGroup::class)->create();
        $editedActivityGroup = factory(ActivityGroup::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/activity_groups/'.$activityGroup->id,
            $editedActivityGroup
        );

        $this->assertApiResponse($editedActivityGroup);
    }

    /**
     * @test
     */
    public function test_delete_activity_group()
    {
        $activityGroup = factory(ActivityGroup::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/activity_groups/'.$activityGroup->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/activity_groups/'.$activityGroup->id
        );

        $this->response->assertStatus(404);
    }
}
