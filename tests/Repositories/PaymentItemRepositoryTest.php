<?php namespace Tests\Repositories;

use App\Models\PaymentItem;
use App\Repositories\PaymentItemRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PaymentItemRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PaymentItemRepository
     */
    protected $paymentItemRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->paymentItemRepo = \App::make(PaymentItemRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_payment_item()
    {
        $paymentItem = PaymentItem::factory()->make()->toArray();

        $createdPaymentItem = $this->paymentItemRepo->create($paymentItem);

        $createdPaymentItem = $createdPaymentItem->toArray();
        $this->assertArrayHasKey('id', $createdPaymentItem);
        $this->assertNotNull($createdPaymentItem['id'], 'Created PaymentItem must have id specified');
        $this->assertNotNull(PaymentItem::find($createdPaymentItem['id']), 'PaymentItem with given id must be in DB');
        $this->assertModelData($paymentItem, $createdPaymentItem);
    }

    /**
     * @test read
     */
    public function test_read_payment_item()
    {
        $paymentItem = PaymentItem::factory()->create();

        $dbPaymentItem = $this->paymentItemRepo->find($paymentItem->id);

        $dbPaymentItem = $dbPaymentItem->toArray();
        $this->assertModelData($paymentItem->toArray(), $dbPaymentItem);
    }

    /**
     * @test update
     */
    public function test_update_payment_item()
    {
        $paymentItem = PaymentItem::factory()->create();
        $fakePaymentItem = PaymentItem::factory()->make()->toArray();

        $updatedPaymentItem = $this->paymentItemRepo->update($fakePaymentItem, $paymentItem->id);

        $this->assertModelData($fakePaymentItem, $updatedPaymentItem->toArray());
        $dbPaymentItem = $this->paymentItemRepo->find($paymentItem->id);
        $this->assertModelData($fakePaymentItem, $dbPaymentItem->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_payment_item()
    {
        $paymentItem = PaymentItem::factory()->create();

        $resp = $this->paymentItemRepo->delete($paymentItem->id);

        $this->assertTrue($resp);
        $this->assertNull(PaymentItem::find($paymentItem->id), 'PaymentItem should not exist in DB');
    }
}
