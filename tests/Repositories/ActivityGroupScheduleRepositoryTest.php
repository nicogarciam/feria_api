<?php namespace Tests\Repositories;

use App\Models\ActivityGroupSchedule;
use App\Repositories\ActivityGroupScheduleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ActivityGroupScheduleRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ActivityGroupScheduleRepository
     */
    protected $activityGroupScheduleRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->activityGroupScheduleRepo = \App::make(ActivityGroupScheduleRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_activity_group_schedule()
    {
        $activityGroupSchedule = factory(ActivityGroupSchedule::class)->make()->toArray();

        $createdActivityGroupSchedule = $this->activityGroupScheduleRepo->create($activityGroupSchedule);

        $createdActivityGroupSchedule = $createdActivityGroupSchedule->toArray();
        $this->assertArrayHasKey('id', $createdActivityGroupSchedule);
        $this->assertNotNull($createdActivityGroupSchedule['id'], 'Created ActivityGroupSchedule must have id specified');
        $this->assertNotNull(ActivityGroupSchedule::find($createdActivityGroupSchedule['id']), 'ActivityGroupSchedule with given id must be in DB');
        $this->assertModelData($activityGroupSchedule, $createdActivityGroupSchedule);
    }

    /**
     * @test read
     */
    public function test_read_activity_group_schedule()
    {
        $activityGroupSchedule = factory(ActivityGroupSchedule::class)->create();

        $dbActivityGroupSchedule = $this->activityGroupScheduleRepo->find($activityGroupSchedule->id);

        $dbActivityGroupSchedule = $dbActivityGroupSchedule->toArray();
        $this->assertModelData($activityGroupSchedule->toArray(), $dbActivityGroupSchedule);
    }

    /**
     * @test update
     */
    public function test_update_activity_group_schedule()
    {
        $activityGroupSchedule = factory(ActivityGroupSchedule::class)->create();
        $fakeActivityGroupSchedule = factory(ActivityGroupSchedule::class)->make()->toArray();

        $updatedActivityGroupSchedule = $this->activityGroupScheduleRepo->update($fakeActivityGroupSchedule, $activityGroupSchedule->id);

        $this->assertModelData($fakeActivityGroupSchedule, $updatedActivityGroupSchedule->toArray());
        $dbActivityGroupSchedule = $this->activityGroupScheduleRepo->find($activityGroupSchedule->id);
        $this->assertModelData($fakeActivityGroupSchedule, $dbActivityGroupSchedule->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_activity_group_schedule()
    {
        $activityGroupSchedule = factory(ActivityGroupSchedule::class)->create();

        $resp = $this->activityGroupScheduleRepo->delete($activityGroupSchedule->id);

        $this->assertTrue($resp);
        $this->assertNull(ActivityGroupSchedule::find($activityGroupSchedule->id), 'ActivityGroupSchedule should not exist in DB');
    }
}
