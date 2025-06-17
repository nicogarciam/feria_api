<?php namespace Tests\Repositories;

use App\Models\ActivitySubscription;
use App\Repositories\ActivitySubscriptionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ActivitySubscriptionRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ActivitySubscriptionRepository
     */
    protected $activitySubscriptionRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->activitySubscriptionRepo = \App::make(ActivitySubscriptionRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_activity_subscription()
    {
        $activitySubscription = ActivitySubscription::factory()->make()->toArray();

        $createdActivitySubscription = $this->activitySubscriptionRepo->create($activitySubscription);

        $createdActivitySubscription = $createdActivitySubscription->toArray();
        $this->assertArrayHasKey('id', $createdActivitySubscription);
        $this->assertNotNull($createdActivitySubscription['id'], 'Created ActivitySubscription must have id specified');
        $this->assertNotNull(ActivitySubscription::find($createdActivitySubscription['id']), 'ActivitySubscription with given id must be in DB');
        $this->assertModelData($activitySubscription, $createdActivitySubscription);
    }

    /**
     * @test read
     */
    public function test_read_activity_subscription()
    {
        $activitySubscription = ActivitySubscription::factory()->create();

        $dbActivitySubscription = $this->activitySubscriptionRepo->find($activitySubscription->id);

        $dbActivitySubscription = $dbActivitySubscription->toArray();
        $this->assertModelData($activitySubscription->toArray(), $dbActivitySubscription);
    }

    /**
     * @test update
     */
    public function test_update_activity_subscription()
    {
        $activitySubscription = ActivitySubscription::factory()->create();
        $fakeActivitySubscription = ActivitySubscription::factory()->make()->toArray();

        $updatedActivitySubscription = $this->activitySubscriptionRepo->update($fakeActivitySubscription, $activitySubscription->id);

        $this->assertModelData($fakeActivitySubscription, $updatedActivitySubscription->toArray());
        $dbActivitySubscription = $this->activitySubscriptionRepo->find($activitySubscription->id);
        $this->assertModelData($fakeActivitySubscription, $dbActivitySubscription->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_activity_subscription()
    {
        $activitySubscription = ActivitySubscription::factory()->create();

        $resp = $this->activitySubscriptionRepo->delete($activitySubscription->id);

        $this->assertTrue($resp);
        $this->assertNull(ActivitySubscription::find($activitySubscription->id), 'ActivitySubscription should not exist in DB');
    }
}
