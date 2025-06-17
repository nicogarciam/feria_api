<?php namespace Tests\Repositories;

use App\Models\Affiliate;
use App\Repositories\AffiliateRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AffiliateRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AffiliateRepository
     */
    protected $affiliateRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->affiliateRepo = \App::make(AffiliateRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_affiliate()
    {
        $affiliate = factory(Affiliate::class)->make()->toArray();

        $createdAffiliate = $this->affiliateRepo->create($affiliate);

        $createdAffiliate = $createdAffiliate->toArray();
        $this->assertArrayHasKey('id', $createdAffiliate);
        $this->assertNotNull($createdAffiliate['id'], 'Created Affiliate must have id specified');
        $this->assertNotNull(Affiliate::find($createdAffiliate['id']), 'Affiliate with given id must be in DB');
        $this->assertModelData($affiliate, $createdAffiliate);
    }

    /**
     * @test read
     */
    public function test_read_affiliate()
    {
        $affiliate = factory(Affiliate::class)->create();

        $dbAffiliate = $this->affiliateRepo->find($affiliate->id);

        $dbAffiliate = $dbAffiliate->toArray();
        $this->assertModelData($affiliate->toArray(), $dbAffiliate);
    }

    /**
     * @test update
     */
    public function test_update_affiliate()
    {
        $affiliate = factory(Affiliate::class)->create();
        $fakeAffiliate = factory(Affiliate::class)->make()->toArray();

        $updatedAffiliate = $this->affiliateRepo->update($fakeAffiliate, $affiliate->id);

        $this->assertModelData($fakeAffiliate, $updatedAffiliate->toArray());
        $dbAffiliate = $this->affiliateRepo->find($affiliate->id);
        $this->assertModelData($fakeAffiliate, $dbAffiliate->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_affiliate()
    {
        $affiliate = factory(Affiliate::class)->create();

        $resp = $this->affiliateRepo->delete($affiliate->id);

        $this->assertTrue($resp);
        $this->assertNull(Affiliate::find($affiliate->id), 'Affiliate should not exist in DB');
    }
}
