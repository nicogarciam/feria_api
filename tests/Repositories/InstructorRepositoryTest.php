<?php namespace Tests\Repositories;

use App\Models\Instructor;
use App\Repositories\InstructorRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class InstructorRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var InstructorRepository
     */
    protected $instructorRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->instructorRepo = \App::make(InstructorRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_instructor()
    {
        $instructor = factory(Instructor::class)->make()->toArray();

        $createdInstructor = $this->instructorRepo->create($instructor);

        $createdInstructor = $createdInstructor->toArray();
        $this->assertArrayHasKey('id', $createdInstructor);
        $this->assertNotNull($createdInstructor['id'], 'Created Instructor must have id specified');
        $this->assertNotNull(Instructor::find($createdInstructor['id']), 'Instructor with given id must be in DB');
        $this->assertModelData($instructor, $createdInstructor);
    }

    /**
     * @test read
     */
    public function test_read_instructor()
    {
        $instructor = factory(Instructor::class)->create();

        $dbInstructor = $this->instructorRepo->find($instructor->id);

        $dbInstructor = $dbInstructor->toArray();
        $this->assertModelData($instructor->toArray(), $dbInstructor);
    }

    /**
     * @test update
     */
    public function test_update_instructor()
    {
        $instructor = factory(Instructor::class)->create();
        $fakeInstructor = factory(Instructor::class)->make()->toArray();

        $updatedInstructor = $this->instructorRepo->update($fakeInstructor, $instructor->id);

        $this->assertModelData($fakeInstructor, $updatedInstructor->toArray());
        $dbInstructor = $this->instructorRepo->find($instructor->id);
        $this->assertModelData($fakeInstructor, $dbInstructor->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_instructor()
    {
        $instructor = factory(Instructor::class)->create();

        $resp = $this->instructorRepo->delete($instructor->id);

        $this->assertTrue($resp);
        $this->assertNull(Instructor::find($instructor->id), 'Instructor should not exist in DB');
    }
}
