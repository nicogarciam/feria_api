<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PaymentState;

class PaymentStateApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_payment_state()
    {
        $paymentState = PaymentState::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/payment_states', $paymentState
        );

        $this->assertApiResponse($paymentState);
    }

    /**
     * @test
     */
    public function test_read_payment_state()
    {
        $paymentState = PaymentState::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/payment_states/'.$paymentState->id
        );

        $this->assertApiResponse($paymentState->toArray());
    }

    /**
     * @test
     */
    public function test_update_payment_state()
    {
        $paymentState = PaymentState::factory()->create();
        $editedPaymentState = PaymentState::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/payment_states/'.$paymentState->id,
            $editedPaymentState
        );

        $this->assertApiResponse($editedPaymentState);
    }

    /**
     * @test
     */
    public function test_delete_payment_state()
    {
        $paymentState = PaymentState::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/payment_states/'.$paymentState->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/payment_states/'.$paymentState->id
        );

        $this->response->assertStatus(404);
    }
}
