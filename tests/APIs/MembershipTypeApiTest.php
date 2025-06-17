<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\MembershipType;

class MembershipTypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_membership_type()
    {
        $membershipType = factory(MembershipType::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/membership_types', $membershipType
        );

        $this->assertApiResponse($membershipType);
    }

    /**
     * @test
     */
    public function test_read_membership_type()
    {
        $membershipType = factory(MembershipType::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/membership_types/'.$membershipType->id
        );

        $this->assertApiResponse($membershipType->toArray());
    }

    /**
     * @test
     */
    public function test_update_membership_type()
    {
        $membershipType = factory(MembershipType::class)->create();
        $editedMembershipType = factory(MembershipType::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/membership_types/'.$membershipType->id,
            $editedMembershipType
        );

        $this->assertApiResponse($editedMembershipType);
    }

    /**
     * @test
     */
    public function test_delete_membership_type()
    {
        $membershipType = factory(MembershipType::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/membership_types/'.$membershipType->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/membership_types/'.$membershipType->id
        );

        $this->response->assertStatus(404);
    }
}
