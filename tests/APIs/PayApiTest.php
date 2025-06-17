<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Pay;

class PayApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_pay()
    {
        $pay = factory(Pay::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/pays', $pay
        );

        $this->assertApiResponse($pay);
    }

    /**
     * @test
     */
    public function test_read_pay()
    {
        $pay = factory(Pay::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/pays/'.$pay->id
        );

        $this->assertApiResponse($pay->toArray());
    }

    /**
     * @test
     */
    public function test_update_pay()
    {
        $pay = factory(Pay::class)->create();
        $editedPay = factory(Pay::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/pays/'.$pay->id,
            $editedPay
        );

        $this->assertApiResponse($editedPay);
    }

    /**
     * @test
     */
    public function test_delete_pay()
    {
        $pay = factory(Pay::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/pays/'.$pay->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/pays/'.$pay->id
        );

        $this->response->assertStatus(404);
    }
}
