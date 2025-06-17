<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\FavoriteBenefit;

class FavoriteBenefitApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_favorite_benefit()
    {
        $favoriteBenefit = factory(FavoriteBenefit::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/favorite_benefits', $favoriteBenefit
        );

        $this->assertApiResponse($favoriteBenefit);
    }

    /**
     * @test
     */
    public function test_read_favorite_benefit()
    {
        $favoriteBenefit = factory(FavoriteBenefit::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/favorite_benefits/'.$favoriteBenefit->id
        );

        $this->assertApiResponse($favoriteBenefit->toArray());
    }

    /**
     * @test
     */
    public function test_update_favorite_benefit()
    {
        $favoriteBenefit = factory(FavoriteBenefit::class)->create();
        $editedFavoriteBenefit = factory(FavoriteBenefit::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/favorite_benefits/'.$favoriteBenefit->id,
            $editedFavoriteBenefit
        );

        $this->assertApiResponse($editedFavoriteBenefit);
    }

    /**
     * @test
     */
    public function test_delete_favorite_benefit()
    {
        $favoriteBenefit = factory(FavoriteBenefit::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/favorite_benefits/'.$favoriteBenefit->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/favorite_benefits/'.$favoriteBenefit->id
        );

        $this->response->assertStatus(404);
    }
}
