<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\$MODEL_NAME;

class $MODEL_NAMEApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_$_m_o_d_e_l__n_a_m_e()
    {
        $$MODELNAME = factory($MODEL_NAME::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/$_m_o_d_e_l__n_a_m_e_s', $$MODELNAME
        );

        $this->assertApiResponse($$MODELNAME);
    }

    /**
     * @test
     */
    public function test_read_$_m_o_d_e_l__n_a_m_e()
    {
        $$MODELNAME = factory($MODEL_NAME::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/$_m_o_d_e_l__n_a_m_e_s/'.$$MODELNAME->id
        );

        $this->assertApiResponse($$MODELNAME->toArray());
    }

    /**
     * @test
     */
    public function test_update_$_m_o_d_e_l__n_a_m_e()
    {
        $$MODELNAME = factory($MODEL_NAME::class)->create();
        $edited$MODEL_NAME = factory($MODEL_NAME::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/$_m_o_d_e_l__n_a_m_e_s/'.$$MODELNAME->id,
            $edited$MODEL_NAME
        );

        $this->assertApiResponse($edited$MODEL_NAME);
    }

    /**
     * @test
     */
    public function test_delete_$_m_o_d_e_l__n_a_m_e()
    {
        $$MODELNAME = factory($MODEL_NAME::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/$_m_o_d_e_l__n_a_m_e_s/'.$$MODELNAME->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/$_m_o_d_e_l__n_a_m_e_s/'.$$MODELNAME->id
        );

        $this->response->assertStatus(404);
    }
}
