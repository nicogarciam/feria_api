<?php namespace Tests\Repositories;

use App\Models\Fee;
use App\Repositories\FeeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FeeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FeeRepository
     */
    protected $feeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->feeRepo = \App::make(FeeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_fee()
    {
        $fee = Fee::factory()->make()->toArray();

        $createdFee = $this->feeRepo->create($fee);

        $createdFee = $createdFee->toArray();
        $this->assertArrayHasKey('id', $createdFee);
        $this->assertNotNull($createdFee['id'], 'Created Fee must have id specified');
        $this->assertNotNull(Fee::find($createdFee['id']), 'Fee with given id must be in DB');
        $this->assertModelData($fee, $createdFee);
    }

    /**
     * @test read
     */
    public function test_read_fee()
    {
        $fee = Fee::factory()->create();

        $dbFee = $this->feeRepo->find($fee->id);

        $dbFee = $dbFee->toArray();
        $this->assertModelData($fee->toArray(), $dbFee);
    }

    /**
     * @test update
     */
    public function test_update_fee()
    {
        $fee = Fee::factory()->create();
        $fakeFee = Fee::factory()->make()->toArray();

        $updatedFee = $this->feeRepo->update($fakeFee, $fee->id);

        $this->assertModelData($fakeFee, $updatedFee->toArray());
        $dbFee = $this->feeRepo->find($fee->id);
        $this->assertModelData($fakeFee, $dbFee->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_fee()
    {
        $fee = Fee::factory()->create();

        $resp = $this->feeRepo->delete($fee->id);

        $this->assertTrue($resp);
        $this->assertNull(Fee::find($fee->id), 'Fee should not exist in DB');
    }
}
