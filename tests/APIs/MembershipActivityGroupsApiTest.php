<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\MembershipActivityGroups;

class MembershipActivityGroupsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_membership_activity_groups()
    {
        $membershipActivityGroups = MembershipActivityGroups::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/membership_activity_groups', $membershipActivityGroups
        );

        $this->assertApiResponse($membershipActivityGroups);
    }

    /**
     * @test
     */
    public function test_read_membership_activity_groups()
    {
        $membershipActivityGroups = MembershipActivityGroups::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/membership_activity_groups/'.$membershipActivityGroups->id
        );

        $this->assertApiResponse($membershipActivityGroups->toArray());
    }

    /**
     * @test
     */
    public function test_update_membership_activity_groups()
    {
        $membershipActivityGroups = MembershipActivityGroups::factory()->create();
        $editedMembershipActivityGroups = MembershipActivityGroups::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/membership_activity_groups/'.$membershipActivityGroups->id,
            $editedMembershipActivityGroups
        );

        $this->assertApiResponse($editedMembershipActivityGroups);
    }

    /**
     * @test
     */
    public function test_delete_membership_activity_groups()
    {
        $membershipActivityGroups = MembershipActivityGroups::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/membership_activity_groups/'.$membershipActivityGroups->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/membership_activity_groups/'.$membershipActivityGroups->id
        );

        $this->response->assertStatus(404);
    }
}
