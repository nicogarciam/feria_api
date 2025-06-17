<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Customer;

class GuestApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_guest()
    {
        $guest = Customer::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/guests', $guest
        );

        $this->assertApiResponse($guest);
    }

    /**
     * @test
     */
    public function test_read_guest()
    {
        $guest = Customer::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/guests/'.$guest->id
        );

        $this->assertApiResponse($guest->toArray());
    }

    /**
     * @test
     */
    public function test_update_guest()
    {
        $guest = Customer::factory()->create();
        $editedGuest = Customer::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/guests/'.$guest->id,
            $editedGuest
        );

        $this->assertApiResponse($editedGuest);
    }

    /**
     * @test
     */
    public function test_delete_guest()
    {
        $guest = Customer::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/guests/'.$guest->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/guests/'.$guest->id
        );

        $this->response->assertStatus(404);
    }
}
