<?php namespace Tests\Repositories;

use App\Models\Pay;
use App\Repositories\PayRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PayRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PayRepository
     */
    protected $payRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->payRepo = \App::make(PayRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_pay()
    {
        $pay = factory(Pay::class)->make()->toArray();

        $createdPay = $this->payRepo->create($pay);

        $createdPay = $createdPay->toArray();
        $this->assertArrayHasKey('id', $createdPay);
        $this->assertNotNull($createdPay['id'], 'Created Pay must have id specified');
        $this->assertNotNull(Pay::find($createdPay['id']), 'Pay with given id must be in DB');
        $this->assertModelData($pay, $createdPay);
    }

    /**
     * @test read
     */
    public function test_read_pay()
    {
        $pay = factory(Pay::class)->create();

        $dbPay = $this->payRepo->find($pay->id);

        $dbPay = $dbPay->toArray();
        $this->assertModelData($pay->toArray(), $dbPay);
    }

    /**
     * @test update
     */
    public function test_update_pay()
    {
        $pay = factory(Pay::class)->create();
        $fakePay = factory(Pay::class)->make()->toArray();

        $updatedPay = $this->payRepo->update($fakePay, $pay->id);

        $this->assertModelData($fakePay, $updatedPay->toArray());
        $dbPay = $this->payRepo->find($pay->id);
        $this->assertModelData($fakePay, $dbPay->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_pay()
    {
        $pay = factory(Pay::class)->create();

        $resp = $this->payRepo->delete($pay->id);

        $this->assertTrue($resp);
        $this->assertNull(Pay::find($pay->id), 'Pay should not exist in DB');
    }
}
