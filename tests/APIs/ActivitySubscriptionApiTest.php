<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ActivitySubscription;

class ActivitySubscriptionApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_activity_subscription()
    {
        $activitySubscription = ActivitySubscription::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/activity_subscriptions', $activitySubscription
        );

        $this->assertApiResponse($activitySubscription);
    }

    /**
     * @test
     */
    public function test_read_activity_subscription()
    {
        $activitySubscription = ActivitySubscription::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/activity_subscriptions/'.$activitySubscription->id
        );

        $this->assertApiResponse($activitySubscription->toArray());
    }

    /**
     * @test
     */
    public function test_update_activity_subscription()
    {
        $activitySubscription = ActivitySubscription::factory()->create();
        $editedActivitySubscription = ActivitySubscription::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/activity_subscriptions/'.$activitySubscription->id,
            $editedActivitySubscription
        );

        $this->assertApiResponse($editedActivitySubscription);
    }

    /**
     * @test
     */
    public function test_delete_activity_subscription()
    {
        $activitySubscription = ActivitySubscription::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/activity_subscriptions/'.$activitySubscription->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/activity_subscriptions/'.$activitySubscription->id
        );

        $this->response->assertStatus(404);
    }
}
