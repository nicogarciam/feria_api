<?php namespace Tests\Repositories;

use App\Models\Movement;
use App\Repositories\MovementRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class MovementRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var MovementRepository
     */
    protected $movementRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->movementRepo = \App::make(MovementRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_movement()
    {
        $movement = Movement::factory()->make()->toArray();

        $createdMovement = $this->movementRepo->create($movement);

        $createdMovement = $createdMovement->toArray();
        $this->assertArrayHasKey('id', $createdMovement);
        $this->assertNotNull($createdMovement['id'], 'Created Movement must have id specified');
        $this->assertNotNull(Movement::find($createdMovement['id']), 'Movement with given id must be in DB');
        $this->assertModelData($movement, $createdMovement);
    }

    /**
     * @test read
     */
    public function test_read_movement()
    {
        $movement = Movement::factory()->create();

        $dbMovement = $this->movementRepo->find($movement->id);

        $dbMovement = $dbMovement->toArray();
        $this->assertModelData($movement->toArray(), $dbMovement);
    }

    /**
     * @test update
     */
    public function test_update_movement()
    {
        $movement = Movement::factory()->create();
        $fakeMovement = Movement::factory()->make()->toArray();

        $updatedMovement = $this->movementRepo->update($fakeMovement, $movement->id);

        $this->assertModelData($fakeMovement, $updatedMovement->toArray());
        $dbMovement = $this->movementRepo->find($movement->id);
        $this->assertModelData($fakeMovement, $dbMovement->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_movement()
    {
        $movement = Movement::factory()->create();

        $resp = $this->movementRepo->delete($movement->id);

        $this->assertTrue($resp);
        $this->assertNull(Movement::find($movement->id), 'Movement should not exist in DB');
    }
}
