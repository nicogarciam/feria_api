<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Benefit;

class BenefitApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_benefit()
    {
        $benefit = factory(Benefit::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/benefits', $benefit
        );

        $this->assertApiResponse($benefit);
    }

    /**
     * @test
     */
    public function test_read_benefit()
    {
        $benefit = factory(Benefit::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/benefits/'.$benefit->id
        );

        $this->assertApiResponse($benefit->toArray());
    }

    /**
     * @test
     */
    public function test_update_benefit()
    {
        $benefit = factory(Benefit::class)->create();
        $editedBenefit = factory(Benefit::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/benefits/'.$benefit->id,
            $editedBenefit
        );

        $this->assertApiResponse($editedBenefit);
    }

    /**
     * @test
     */
    public function test_delete_benefit()
    {
        $benefit = factory(Benefit::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/benefits/'.$benefit->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/benefits/'.$benefit->id
        );

        $this->response->assertStatus(404);
    }
}
