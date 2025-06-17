<?php namespace Tests\Repositories;

use App\Models\MembershipType;
use App\Repositories\MembershipTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class MembershipTypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var MembershipTypeRepository
     */
    protected $membershipTypeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->membershipTypeRepo = \App::make(MembershipTypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_membership_type()
    {
        $membershipType = factory(MembershipType::class)->make()->toArray();

        $createdMembershipType = $this->membershipTypeRepo->create($membershipType);

        $createdMembershipType = $createdMembershipType->toArray();
        $this->assertArrayHasKey('id', $createdMembershipType);
        $this->assertNotNull($createdMembershipType['id'], 'Created MembershipType must have id specified');
        $this->assertNotNull(MembershipType::find($createdMembershipType['id']), 'MembershipType with given id must be in DB');
        $this->assertModelData($membershipType, $createdMembershipType);
    }

    /**
     * @test read
     */
    public function test_read_membership_type()
    {
        $membershipType = factory(MembershipType::class)->create();

        $dbMembershipType = $this->membershipTypeRepo->find($membershipType->id);

        $dbMembershipType = $dbMembershipType->toArray();
        $this->assertModelData($membershipType->toArray(), $dbMembershipType);
    }

    /**
     * @test update
     */
    public function test_update_membership_type()
    {
        $membershipType = factory(MembershipType::class)->create();
        $fakeMembershipType = factory(MembershipType::class)->make()->toArray();

        $updatedMembershipType = $this->membershipTypeRepo->update($fakeMembershipType, $membershipType->id);

        $this->assertModelData($fakeMembershipType, $updatedMembershipType->toArray());
        $dbMembershipType = $this->membershipTypeRepo->find($membershipType->id);
        $this->assertModelData($fakeMembershipType, $dbMembershipType->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_membership_type()
    {
        $membershipType = factory(MembershipType::class)->create();

        $resp = $this->membershipTypeRepo->delete($membershipType->id);

        $this->assertTrue($resp);
        $this->assertNull(MembershipType::find($membershipType->id), 'MembershipType should not exist in DB');
    }
}
