<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Movement;

class MovementApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_movement()
    {
        $movement = Movement::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/movements', $movement
        );

        $this->assertApiResponse($movement);
    }

    /**
     * @test
     */
    public function test_read_movement()
    {
        $movement = Movement::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/movements/'.$movement->id
        );

        $this->assertApiResponse($movement->toArray());
    }

    /**
     * @test
     */
    public function test_update_movement()
    {
        $movement = Movement::factory()->create();
        $editedMovement = Movement::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/movements/'.$movement->id,
            $editedMovement
        );

        $this->assertApiResponse($editedMovement);
    }

    /**
     * @test
     */
    public function test_delete_movement()
    {
        $movement = Movement::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/movements/'.$movement->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/movements/'.$movement->id
        );

        $this->response->assertStatus(404);
    }
}
