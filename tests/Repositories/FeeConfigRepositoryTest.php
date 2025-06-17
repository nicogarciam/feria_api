<?php namespace Tests\Repositories;

use App\Models\FeeConfig;
use App\Repositories\FeeConfigRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FeeConfigRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FeeConfigRepository
     */
    protected $feeConfigRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->feeConfigRepo = \App::make(FeeConfigRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_fee_config()
    {
        $feeConfig = FeeConfig::factory()->make()->toArray();

        $createdFeeConfig = $this->feeConfigRepo->create($feeConfig);

        $createdFeeConfig = $createdFeeConfig->toArray();
        $this->assertArrayHasKey('id', $createdFeeConfig);
        $this->assertNotNull($createdFeeConfig['id'], 'Created FeeConfig must have id specified');
        $this->assertNotNull(FeeConfig::find($createdFeeConfig['id']), 'FeeConfig with given id must be in DB');
        $this->assertModelData($feeConfig, $createdFeeConfig);
    }

    /**
     * @test read
     */
    public function test_read_fee_config()
    {
        $feeConfig = FeeConfig::factory()->create();

        $dbFeeConfig = $this->feeConfigRepo->find($feeConfig->id);

        $dbFeeConfig = $dbFeeConfig->toArray();
        $this->assertModelData($feeConfig->toArray(), $dbFeeConfig);
    }

    /**
     * @test update
     */
    public function test_update_fee_config()
    {
        $feeConfig = FeeConfig::factory()->create();
        $fakeFeeConfig = FeeConfig::factory()->make()->toArray();

        $updatedFeeConfig = $this->feeConfigRepo->update($fakeFeeConfig, $feeConfig->id);

        $this->assertModelData($fakeFeeConfig, $updatedFeeConfig->toArray());
        $dbFeeConfig = $this->feeConfigRepo->find($feeConfig->id);
        $this->assertModelData($fakeFeeConfig, $dbFeeConfig->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_fee_config()
    {
        $feeConfig = FeeConfig::factory()->create();

        $resp = $this->feeConfigRepo->delete($feeConfig->id);

        $this->assertTrue($resp);
        $this->assertNull(FeeConfig::find($feeConfig->id), 'FeeConfig should not exist in DB');
    }
}
