<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\MemberTypeHist;

class MemberTypeHistApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_member_type_hist()
    {
        $memberTypeHist = factory(MemberTypeHist::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/member_type_hists', $memberTypeHist
        );

        $this->assertApiResponse($memberTypeHist);
    }

    /**
     * @test
     */
    public function test_read_member_type_hist()
    {
        $memberTypeHist = factory(MemberTypeHist::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/member_type_hists/'.$memberTypeHist->id
        );

        $this->assertApiResponse($memberTypeHist->toArray());
    }

    /**
     * @test
     */
    public function test_update_member_type_hist()
    {
        $memberTypeHist = factory(MemberTypeHist::class)->create();
        $editedMemberTypeHist = factory(MemberTypeHist::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/member_type_hists/'.$memberTypeHist->id,
            $editedMemberTypeHist
        );

        $this->assertApiResponse($editedMemberTypeHist);
    }

    /**
     * @test
     */
    public function test_delete_member_type_hist()
    {
        $memberTypeHist = factory(MemberTypeHist::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/member_type_hists/'.$memberTypeHist->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/member_type_hists/'.$memberTypeHist->id
        );

        $this->response->assertStatus(404);
    }
}
