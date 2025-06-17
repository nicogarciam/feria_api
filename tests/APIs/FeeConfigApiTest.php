<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\FeeConfig;

class FeeConfigApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_fee_config()
    {
        $feeConfig = FeeConfig::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/fee_configs', $feeConfig
        );

        $this->assertApiResponse($feeConfig);
    }

    /**
     * @test
     */
    public function test_read_fee_config()
    {
        $feeConfig = FeeConfig::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/fee_configs/'.$feeConfig->id
        );

        $this->assertApiResponse($feeConfig->toArray());
    }

    /**
     * @test
     */
    public function test_update_fee_config()
    {
        $feeConfig = FeeConfig::factory()->create();
        $editedFeeConfig = FeeConfig::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/fee_configs/'.$feeConfig->id,
            $editedFeeConfig
        );

        $this->assertApiResponse($editedFeeConfig);
    }

    /**
     * @test
     */
    public function test_delete_fee_config()
    {
        $feeConfig = FeeConfig::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/fee_configs/'.$feeConfig->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/fee_configs/'.$feeConfig->id
        );

        $this->response->assertStatus(404);
    }
}
