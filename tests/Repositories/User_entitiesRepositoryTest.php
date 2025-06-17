<?php namespace Tests\Repositories;

use App\Models\User_entity;
use App\Repositories\User_entitiesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class User_entitiesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var User_entitiesRepository
     */
    protected $userEntitiesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->userEntitiesRepo = \App::make(User_entitiesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_user_entities()
    {
        $userEntities = factory(User_entity::class)->make()->toArray();

        $createdUser_entities = $this->userEntitiesRepo->create($userEntities);

        $createdUser_entities = $createdUser_entities->toArray();
        $this->assertArrayHasKey('id', $createdUser_entities);
        $this->assertNotNull($createdUser_entities['id'], 'Created User_entities must have id specified');
        $this->assertNotNull(User_entity::find($createdUser_entities['id']), 'User_entities with given id must be in DB');
        $this->assertModelData($userEntities, $createdUser_entities);
    }

    /**
     * @test read
     */
    public function test_read_user_entities()
    {
        $userEntities = factory(User_entity::class)->create();

        $dbUser_entities = $this->userEntitiesRepo->find($userEntities->id);

        $dbUser_entities = $dbUser_entities->toArray();
        $this->assertModelData($userEntities->toArray(), $dbUser_entities);
    }

    /**
     * @test update
     */
    public function test_update_user_entities()
    {
        $userEntities = factory(User_entity::class)->create();
        $fakeUser_entities = factory(User_entity::class)->make()->toArray();

        $updatedUser_entities = $this->userEntitiesRepo->update($fakeUser_entities, $userEntities->id);

        $this->assertModelData($fakeUser_entities, $updatedUser_entities->toArray());
        $dbUser_entities = $this->userEntitiesRepo->find($userEntities->id);
        $this->assertModelData($fakeUser_entities, $dbUser_entities->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_user_entities()
    {
        $userEntities = factory(User_entity::class)->create();

        $resp = $this->userEntitiesRepo->delete($userEntities->id);

        $this->assertTrue($resp);
        $this->assertNull(User_entity::find($userEntities->id), 'User_entities should not exist in DB');
    }
}
