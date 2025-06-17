<?php namespace Tests\Repositories;

use App\Models\ActivityGroup;
use App\Repositories\ActivityGroupRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ActivityGroupRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ActivityGroupRepository
     */
    protected $activityGroupRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->activityGroupRepo = \App::make(ActivityGroupRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_activity_group()
    {
        $activityGroup = factory(ActivityGroup::class)->make()->toArray();

        $createdActivityGroup = $this->activityGroupRepo->create($activityGroup);

        $createdActivityGroup = $createdActivityGroup->toArray();
        $this->assertArrayHasKey('id', $createdActivityGroup);
        $this->assertNotNull($createdActivityGroup['id'], 'Created ActivityGroup must have id specified');
        $this->assertNotNull(ActivityGroup::find($createdActivityGroup['id']), 'ActivityGroup with given id must be in DB');
        $this->assertModelData($activityGroup, $createdActivityGroup);
    }

    /**
     * @test read
     */
    public function test_read_activity_group()
    {
        $activityGroup = factory(ActivityGroup::class)->create();

        $dbActivityGroup = $this->activityGroupRepo->find($activityGroup->id);

        $dbActivityGroup = $dbActivityGroup->toArray();
        $this->assertModelData($activityGroup->toArray(), $dbActivityGroup);
    }

    /**
     * @test update
     */
    public function test_update_activity_group()
    {
        $activityGroup = factory(ActivityGroup::class)->create();
        $fakeActivityGroup = factory(ActivityGroup::class)->make()->toArray();

        $updatedActivityGroup = $this->activityGroupRepo->update($fakeActivityGroup, $activityGroup->id);

        $this->assertModelData($fakeActivityGroup, $updatedActivityGroup->toArray());
        $dbActivityGroup = $this->activityGroupRepo->find($activityGroup->id);
        $this->assertModelData($fakeActivityGroup, $dbActivityGroup->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_activity_group()
    {
        $activityGroup = factory(ActivityGroup::class)->create();

        $resp = $this->activityGroupRepo->delete($activityGroup->id);

        $this->assertTrue($resp);
        $this->assertNull(ActivityGroup::find($activityGroup->id), 'ActivityGroup should not exist in DB');
    }
}
