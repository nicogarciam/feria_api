<?php namespace Tests\Repositories;

use App\Models\Entity;
use App\Repositories\EntityRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class EntityRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var EntityRepository
     */
    protected $entityRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->entityRepo = \App::make(EntityRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_entity()
    {
        $entity = factory(Entity::class)->make()->toArray();

        $createdEntity = $this->entityRepo->create($entity);

        $createdEntity = $createdEntity->toArray();
        $this->assertArrayHasKey('id', $createdEntity);
        $this->assertNotNull($createdEntity['id'], 'Created Entity must have id specified');
        $this->assertNotNull(Entity::find($createdEntity['id']), 'Entity with given id must be in DB');
        $this->assertModelData($entity, $createdEntity);
    }

    /**
     * @test read
     */
    public function test_read_entity()
    {
        $entity = factory(Entity::class)->create();

        $dbEntity = $this->entityRepo->find($entity->id);

        $dbEntity = $dbEntity->toArray();
        $this->assertModelData($entity->toArray(), $dbEntity);
    }

    /**
     * @test update
     */
    public function test_update_entity()
    {
        $entity = factory(Entity::class)->create();
        $fakeEntity = factory(Entity::class)->make()->toArray();

        $updatedEntity = $this->entityRepo->update($fakeEntity, $entity->id);

        $this->assertModelData($fakeEntity, $updatedEntity->toArray());
        $dbEntity = $this->entityRepo->find($entity->id);
        $this->assertModelData($fakeEntity, $dbEntity->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_entity()
    {
        $entity = factory(Entity::class)->create();

        $resp = $this->entityRepo->delete($entity->id);

        $this->assertTrue($resp);
        $this->assertNull(Entity::find($entity->id), 'Entity should not exist in DB');
    }
}
