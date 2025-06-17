<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\BankAccount;

class BankAccountApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_bank_account()
    {
        $bankAccount = BankAccount::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/bank_accounts', $bankAccount
        );

        $this->assertApiResponse($bankAccount);
    }

    /**
     * @test
     */
    public function test_read_bank_account()
    {
        $bankAccount = BankAccount::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/bank_accounts/'.$bankAccount->id
        );

        $this->assertApiResponse($bankAccount->toArray());
    }

    /**
     * @test
     */
    public function test_update_bank_account()
    {
        $bankAccount = BankAccount::factory()->create();
        $editedBankAccount = BankAccount::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/bank_accounts/'.$bankAccount->id,
            $editedBankAccount
        );

        $this->assertApiResponse($editedBankAccount);
    }

    /**
     * @test
     */
    public function test_delete_bank_account()
    {
        $bankAccount = BankAccount::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/bank_accounts/'.$bankAccount->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/bank_accounts/'.$bankAccount->id
        );

        $this->response->assertStatus(404);
    }
}
