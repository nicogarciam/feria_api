<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PayItem;

class PayItemApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_pay_item()
    {
        $payItem = PayItem::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/pay_items', $payItem
        );

        $this->assertApiResponse($payItem);
    }

    /**
     * @test
     */
    public function test_read_pay_item()
    {
        $payItem = PayItem::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/pay_items/'.$payItem->id
        );

        $this->assertApiResponse($payItem->toArray());
    }

    /**
     * @test
     */
    public function test_update_pay_item()
    {
        $payItem = PayItem::factory()->create();
        $editedPayItem = PayItem::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/pay_items/'.$payItem->id,
            $editedPayItem
        );

        $this->assertApiResponse($editedPayItem);
    }

    /**
     * @test
     */
    public function test_delete_pay_item()
    {
        $payItem = PayItem::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/pay_items/'.$payItem->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/pay_items/'.$payItem->id
        );

        $this->response->assertStatus(404);
    }
}
