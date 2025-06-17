<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Entity;

class EntityApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_entity()
    {
        $entity = factory(Entity::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/entities', $entity
        );

        $this->assertApiResponse($entity);
    }

    /**
     * @test
     */
    public function test_read_entity()
    {
        $entity = factory(Entity::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/entities/'.$entity->id
        );

        $this->assertApiResponse($entity->toArray());
    }

    /**
     * @test
     */
    public function test_update_entity()
    {
        $entity = factory(Entity::class)->create();
        $editedEntity = factory(Entity::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/entities/'.$entity->id,
            $editedEntity
        );

        $this->assertApiResponse($editedEntity);
    }

    /**
     * @test
     */
    public function test_delete_entity()
    {
        $entity = factory(Entity::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/entities/'.$entity->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/entities/'.$entity->id
        );

        $this->response->assertStatus(404);
    }
}
