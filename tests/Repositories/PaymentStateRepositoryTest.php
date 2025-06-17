<?php namespace Tests\Repositories;

use App\Models\PaymentState;
use App\Repositories\PaymentStateRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PaymentStateRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PaymentStateRepository
     */
    protected $paymentStateRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->paymentStateRepo = \App::make(PaymentStateRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_payment_state()
    {
        $paymentState = PaymentState::factory()->make()->toArray();

        $createdPaymentState = $this->paymentStateRepo->create($paymentState);

        $createdPaymentState = $createdPaymentState->toArray();
        $this->assertArrayHasKey('id', $createdPaymentState);
        $this->assertNotNull($createdPaymentState['id'], 'Created PaymentState must have id specified');
        $this->assertNotNull(PaymentState::find($createdPaymentState['id']), 'PaymentState with given id must be in DB');
        $this->assertModelData($paymentState, $createdPaymentState);
    }

    /**
     * @test read
     */
    public function test_read_payment_state()
    {
        $paymentState = PaymentState::factory()->create();

        $dbPaymentState = $this->paymentStateRepo->find($paymentState->id);

        $dbPaymentState = $dbPaymentState->toArray();
        $this->assertModelData($paymentState->toArray(), $dbPaymentState);
    }

    /**
     * @test update
     */
    public function test_update_payment_state()
    {
        $paymentState = PaymentState::factory()->create();
        $fakePaymentState = PaymentState::factory()->make()->toArray();

        $updatedPaymentState = $this->paymentStateRepo->update($fakePaymentState, $paymentState->id);

        $this->assertModelData($fakePaymentState, $updatedPaymentState->toArray());
        $dbPaymentState = $this->paymentStateRepo->find($paymentState->id);
        $this->assertModelData($fakePaymentState, $dbPaymentState->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_payment_state()
    {
        $paymentState = PaymentState::factory()->create();

        $resp = $this->paymentStateRepo->delete($paymentState->id);

        $this->assertTrue($resp);
        $this->assertNull(PaymentState::find($paymentState->id), 'PaymentState should not exist in DB');
    }
}
