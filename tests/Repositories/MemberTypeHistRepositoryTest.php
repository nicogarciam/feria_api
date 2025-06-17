<?php namespace Tests\Repositories;

use App\Models\MemberTypeHist;
use App\Repositories\MemberTypeHistRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class MemberTypeHistRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var MemberTypeHistRepository
     */
    protected $memberTypeHistRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->memberTypeHistRepo = \App::make(MemberTypeHistRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_member_type_hist()
    {
        $memberTypeHist = factory(MemberTypeHist::class)->make()->toArray();

        $createdMemberTypeHist = $this->memberTypeHistRepo->create($memberTypeHist);

        $createdMemberTypeHist = $createdMemberTypeHist->toArray();
        $this->assertArrayHasKey('id', $createdMemberTypeHist);
        $this->assertNotNull($createdMemberTypeHist['id'], 'Created MemberTypeHist must have id specified');
        $this->assertNotNull(MemberTypeHist::find($createdMemberTypeHist['id']), 'MemberTypeHist with given id must be in DB');
        $this->assertModelData($memberTypeHist, $createdMemberTypeHist);
    }

    /**
     * @test read
     */
    public function test_read_member_type_hist()
    {
        $memberTypeHist = factory(MemberTypeHist::class)->create();

        $dbMemberTypeHist = $this->memberTypeHistRepo->find($memberTypeHist->id);

        $dbMemberTypeHist = $dbMemberTypeHist->toArray();
        $this->assertModelData($memberTypeHist->toArray(), $dbMemberTypeHist);
    }

    /**
     * @test update
     */
    public function test_update_member_type_hist()
    {
        $memberTypeHist = factory(MemberTypeHist::class)->create();
        $fakeMemberTypeHist = factory(MemberTypeHist::class)->make()->toArray();

        $updatedMemberTypeHist = $this->memberTypeHistRepo->update($fakeMemberTypeHist, $memberTypeHist->id);

        $this->assertModelData($fakeMemberTypeHist, $updatedMemberTypeHist->toArray());
        $dbMemberTypeHist = $this->memberTypeHistRepo->find($memberTypeHist->id);
        $this->assertModelData($fakeMemberTypeHist, $dbMemberTypeHist->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_member_type_hist()
    {
        $memberTypeHist = factory(MemberTypeHist::class)->create();

        $resp = $this->memberTypeHistRepo->delete($memberTypeHist->id);

        $this->assertTrue($resp);
        $this->assertNull(MemberTypeHist::find($memberTypeHist->id), 'MemberTypeHist should not exist in DB');
    }
}
