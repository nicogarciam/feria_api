<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\$City;

class $CityApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_$_city()
    {
        $$City = factory($City::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/$_cities', $$City
        );

        $this->assertApiResponse($$City);
    }

    /**
     * @test
     */
    public function test_read_$_city()
    {
        $$City = factory($City::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/$_cities/'.$$City->id
        );

        $this->assertApiResponse($$City->toArray());
    }

    /**
     * @test
     */
    public function test_update_$_city()
    {
        $$City = factory($City::class)->create();
        $edited$City = factory($City::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/$_cities/'.$$City->id,
            $edited$City
        );

        $this->assertApiResponse($edited$City);
    }

    /**
     * @test
     */
    public function test_delete_$_city()
    {
        $$City = factory($City::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/$_cities/'.$$City->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/$_cities/'.$$City->id
        );

        $this->response->assertStatus(404);
    }
}
