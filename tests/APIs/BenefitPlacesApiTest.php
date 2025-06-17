<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\BenefitPlaces;

class BenefitPlacesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_benefit_places()
    {
        $benefitPlaces = factory(BenefitPlaces::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/benefit_places', $benefitPlaces
        );

        $this->assertApiResponse($benefitPlaces);
    }

    /**
     * @test
     */
    public function test_read_benefit_places()
    {
        $benefitPlaces = factory(BenefitPlaces::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/benefit_places/'.$benefitPlaces->id
        );

        $this->assertApiResponse($benefitPlaces->toArray());
    }

    /**
     * @test
     */
    public function test_update_benefit_places()
    {
        $benefitPlaces = factory(BenefitPlaces::class)->create();
        $editedBenefitPlaces = factory(BenefitPlaces::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/benefit_places/'.$benefitPlaces->id,
            $editedBenefitPlaces
        );

        $this->assertApiResponse($editedBenefitPlaces);
    }

    /**
     * @test
     */
    public function test_delete_benefit_places()
    {
        $benefitPlaces = factory(BenefitPlaces::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/benefit_places/'.$benefitPlaces->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/benefit_places/'.$benefitPlaces->id
        );

        $this->response->assertStatus(404);
    }
}
