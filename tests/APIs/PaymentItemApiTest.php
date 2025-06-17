<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PaymentItem;

class PaymentItemApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_payment_item()
    {
        $paymentItem = PaymentItem::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/payment_items', $paymentItem
        );

        $this->assertApiResponse($paymentItem);
    }

    /**
     * @test
     */
    public function test_read_payment_item()
    {
        $paymentItem = PaymentItem::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/payment_items/'.$paymentItem->id
        );

        $this->assertApiResponse($paymentItem->toArray());
    }

    /**
     * @test
     */
    public function test_update_payment_item()
    {
        $paymentItem = PaymentItem::factory()->create();
        $editedPaymentItem = PaymentItem::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/payment_items/'.$paymentItem->id,
            $editedPaymentItem
        );

        $this->assertApiResponse($editedPaymentItem);
    }

    /**
     * @test
     */
    public function test_delete_payment_item()
    {
        $paymentItem = PaymentItem::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/payment_items/'.$paymentItem->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/payment_items/'.$paymentItem->id
        );

        $this->response->assertStatus(404);
    }
}
