<?php namespace Tests\Repositories;

use App\Models\BankAccount;
use App\Repositories\BankAccountRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class BankAccountRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var BankAccountRepository
     */
    protected $bankAccountRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->bankAccountRepo = \App::make(BankAccountRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_bank_account()
    {
        $bankAccount = BankAccount::factory()->make()->toArray();

        $createdBankAccount = $this->bankAccountRepo->create($bankAccount);

        $createdBankAccount = $createdBankAccount->toArray();
        $this->assertArrayHasKey('id', $createdBankAccount);
        $this->assertNotNull($createdBankAccount['id'], 'Created BankAccount must have id specified');
        $this->assertNotNull(BankAccount::find($createdBankAccount['id']), 'BankAccount with given id must be in DB');
        $this->assertModelData($bankAccount, $createdBankAccount);
    }

    /**
     * @test read
     */
    public function test_read_bank_account()
    {
        $bankAccount = BankAccount::factory()->create();

        $dbBankAccount = $this->bankAccountRepo->find($bankAccount->id);

        $dbBankAccount = $dbBankAccount->toArray();
        $this->assertModelData($bankAccount->toArray(), $dbBankAccount);
    }

    /**
     * @test update
     */
    public function test_update_bank_account()
    {
        $bankAccount = BankAccount::factory()->create();
        $fakeBankAccount = BankAccount::factory()->make()->toArray();

        $updatedBankAccount = $this->bankAccountRepo->update($fakeBankAccount, $bankAccount->id);

        $this->assertModelData($fakeBankAccount, $updatedBankAccount->toArray());
        $dbBankAccount = $this->bankAccountRepo->find($bankAccount->id);
        $this->assertModelData($fakeBankAccount, $dbBankAccount->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_bank_account()
    {
        $bankAccount = BankAccount::factory()->create();

        $resp = $this->bankAccountRepo->delete($bankAccount->id);

        $this->assertTrue($resp);
        $this->assertNull(BankAccount::find($bankAccount->id), 'BankAccount should not exist in DB');
    }
}
