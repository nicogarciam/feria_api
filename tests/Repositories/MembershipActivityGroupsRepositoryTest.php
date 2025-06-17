<?php namespace Tests\Repositories;

use App\Models\MembershipActivityGroups;
use App\Repositories\MembershipActivityGroupsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class MembershipActivityGroupsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var MembershipActivityGroupsRepository
     */
    protected $membershipActivityGroupsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->membershipActivityGroupsRepo = \App::make(MembershipActivityGroupsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_membership_activity_groups()
    {
        $membershipActivityGroups = MembershipActivityGroups::factory()->make()->toArray();

        $createdMembershipActivityGroups = $this->membershipActivityGroupsRepo->create($membershipActivityGroups);

        $createdMembershipActivityGroups = $createdMembershipActivityGroups->toArray();
        $this->assertArrayHasKey('id', $createdMembershipActivityGroups);
        $this->assertNotNull($createdMembershipActivityGroups['id'], 'Created MembershipActivityGroups must have id specified');
        $this->assertNotNull(MembershipActivityGroups::find($createdMembershipActivityGroups['id']), 'MembershipActivityGroups with given id must be in DB');
        $this->assertModelData($membershipActivityGroups, $createdMembershipActivityGroups);
    }

    /**
     * @test read
     */
    public function test_read_membership_activity_groups()
    {
        $membershipActivityGroups = MembershipActivityGroups::factory()->create();

        $dbMembershipActivityGroups = $this->membershipActivityGroupsRepo->find($membershipActivityGroups->id);

        $dbMembershipActivityGroups = $dbMembershipActivityGroups->toArray();
        $this->assertModelData($membershipActivityGroups->toArray(), $dbMembershipActivityGroups);
    }

    /**
     * @test update
     */
    public function test_update_membership_activity_groups()
    {
        $membershipActivityGroups = MembershipActivityGroups::factory()->create();
        $fakeMembershipActivityGroups = MembershipActivityGroups::factory()->make()->toArray();

        $updatedMembershipActivityGroups = $this->membershipActivityGroupsRepo->update($fakeMembershipActivityGroups, $membershipActivityGroups->id);

        $this->assertModelData($fakeMembershipActivityGroups, $updatedMembershipActivityGroups->toArray());
        $dbMembershipActivityGroups = $this->membershipActivityGroupsRepo->find($membershipActivityGroups->id);
        $this->assertModelData($fakeMembershipActivityGroups, $dbMembershipActivityGroups->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_membership_activity_groups()
    {
        $membershipActivityGroups = MembershipActivityGroups::factory()->create();

        $resp = $this->membershipActivityGroupsRepo->delete($membershipActivityGroups->id);

        $this->assertTrue($resp);
        $this->assertNull(MembershipActivityGroups::find($membershipActivityGroups->id), 'MembershipActivityGroups should not exist in DB');
    }
}
