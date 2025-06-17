<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Instructor;

class InstructorApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_instructor()
    {
        $instructor = factory(Instructor::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/instructors', $instructor
        );

        $this->assertApiResponse($instructor);
    }

    /**
     * @test
     */
    public function test_read_instructor()
    {
        $instructor = factory(Instructor::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/instructors/'.$instructor->id
        );

        $this->assertApiResponse($instructor->toArray());
    }

    /**
     * @test
     */
    public function test_update_instructor()
    {
        $instructor = factory(Instructor::class)->create();
        $editedInstructor = factory(Instructor::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/instructors/'.$instructor->id,
            $editedInstructor
        );

        $this->assertApiResponse($editedInstructor);
    }

    /**
     * @test
     */
    public function test_delete_instructor()
    {
        $instructor = factory(Instructor::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/instructors/'.$instructor->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/instructors/'.$instructor->id
        );

        $this->response->assertStatus(404);
    }
}
