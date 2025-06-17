<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Membership;

class MembershipApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_membership()
    {
        $membership = factory(Membership::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/memberships', $membership
        );

        $this->assertApiResponse($membership);
    }

    /**
     * @test
     */
    public function test_read_membership()
    {
        $membership = factory(Membership::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/memberships/'.$membership->id
        );

        $this->assertApiResponse($membership->toArray());
    }

    /**
     * @test
     */
    public function test_update_membership()
    {
        $membership = factory(Membership::class)->create();
        $editedMembership = factory(Membership::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/memberships/'.$membership->id,
            $editedMembership
        );

        $this->assertApiResponse($editedMembership);
    }

    /**
     * @test
     */
    public function test_delete_membership()
    {
        $membership = factory(Membership::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/memberships/'.$membership->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/memberships/'.$membership->id
        );

        $this->response->assertStatus(404);
    }
}
