<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\User_entity;

class User_entitiesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_user_entities()
    {
        $userEntities = factory(User_entity::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/user_entities', $userEntities
        );

        $this->assertApiResponse($userEntities);
    }

    /**
     * @test
     */
    public function test_read_user_entities()
    {
        $userEntities = factory(User_entity::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/user_entities/'.$userEntities->id
        );

        $this->assertApiResponse($userEntities->toArray());
    }

    /**
     * @test
     */
    public function test_update_user_entities()
    {
        $userEntities = factory(User_entity::class)->create();
        $editedUser_entities = factory(User_entity::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/user_entities/'.$userEntities->id,
            $editedUser_entities
        );

        $this->assertApiResponse($editedUser_entities);
    }

    /**
     * @test
     */
    public function test_delete_user_entities()
    {
        $userEntities = factory(User_entity::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/user_entities/'.$userEntities->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/user_entities/'.$userEntities->id
        );

        $this->response->assertStatus(404);
    }
}
