<?php namespace Tests\Repositories;

use App\Models\Membership;
use App\Repositories\MembershipRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class MembershipRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var MembershipRepository
     */
    protected $membershipRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->membershipRepo = \App::make(MembershipRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_membership()
    {
        $membership = factory(Membership::class)->make()->toArray();

        $createdMembership = $this->membershipRepo->create($membership);

        $createdMembership = $createdMembership->toArray();
        $this->assertArrayHasKey('id', $createdMembership);
        $this->assertNotNull($createdMembership['id'], 'Created Membership must have id specified');
        $this->assertNotNull(Membership::find($createdMembership['id']), 'Membership with given id must be in DB');
        $this->assertModelData($membership, $createdMembership);
    }

    /**
     * @test read
     */
    public function test_read_membership()
    {
        $membership = factory(Membership::class)->create();

        $dbMembership = $this->membershipRepo->find($membership->id);

        $dbMembership = $dbMembership->toArray();
        $this->assertModelData($membership->toArray(), $dbMembership);
    }

    /**
     * @test update
     */
    public function test_update_membership()
    {
        $membership = factory(Membership::class)->create();
        $fakeMembership = factory(Membership::class)->make()->toArray();

        $updatedMembership = $this->membershipRepo->update($fakeMembership, $membership->id);

        $this->assertModelData($fakeMembership, $updatedMembership->toArray());
        $dbMembership = $this->membershipRepo->find($membership->id);
        $this->assertModelData($fakeMembership, $dbMembership->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_membership()
    {
        $membership = factory(Membership::class)->create();

        $resp = $this->membershipRepo->delete($membership->id);

        $this->assertTrue($resp);
        $this->assertNull(Membership::find($membership->id), 'Membership should not exist in DB');
    }
}
