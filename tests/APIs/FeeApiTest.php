<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Fee;

class FeeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_fee()
    {
        $fee = Fee::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/fees', $fee
        );

        $this->assertApiResponse($fee);
    }

    /**
     * @test
     */
    public function test_read_fee()
    {
        $fee = Fee::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/fees/'.$fee->id
        );

        $this->assertApiResponse($fee->toArray());
    }

    /**
     * @test
     */
    public function test_update_fee()
    {
        $fee = Fee::factory()->create();
        $editedFee = Fee::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/fees/'.$fee->id,
            $editedFee
        );

        $this->assertApiResponse($editedFee);
    }

    /**
     * @test
     */
    public function test_delete_fee()
    {
        $fee = Fee::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/fees/'.$fee->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/fees/'.$fee->id
        );

        $this->response->assertStatus(404);
    }
}
