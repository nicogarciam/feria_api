<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Affiliate;

class AffiliateApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_affiliate()
    {
        $affiliate = factory(Affiliate::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/affiliates', $affiliate
        );

        $this->assertApiResponse($affiliate);
    }

    /**
     * @test
     */
    public function test_read_affiliate()
    {
        $affiliate = factory(Affiliate::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/affiliates/'.$affiliate->id
        );

        $this->assertApiResponse($affiliate->toArray());
    }

    /**
     * @test
     */
    public function test_update_affiliate()
    {
        $affiliate = factory(Affiliate::class)->create();
        $editedAffiliate = factory(Affiliate::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/affiliates/'.$affiliate->id,
            $editedAffiliate
        );

        $this->assertApiResponse($editedAffiliate);
    }

    /**
     * @test
     */
    public function test_delete_affiliate()
    {
        $affiliate = factory(Affiliate::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/affiliates/'.$affiliate->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/affiliates/'.$affiliate->id
        );

        $this->response->assertStatus(404);
    }
}
