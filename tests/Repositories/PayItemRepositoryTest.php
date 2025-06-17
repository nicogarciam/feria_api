<?php namespace Tests\Repositories;

use App\Models\PayItem;
use App\Repositories\PayItemRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PayItemRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PayItemRepository
     */
    protected $payItemRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->payItemRepo = \App::make(PayItemRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_pay_item()
    {
        $payItem = PayItem::factory()->make()->toArray();

        $createdPayItem = $this->payItemRepo->create($payItem);

        $createdPayItem = $createdPayItem->toArray();
        $this->assertArrayHasKey('id', $createdPayItem);
        $this->assertNotNull($createdPayItem['id'], 'Created PayItem must have id specified');
        $this->assertNotNull(PayItem::find($createdPayItem['id']), 'PayItem with given id must be in DB');
        $this->assertModelData($payItem, $createdPayItem);
    }

    /**
     * @test read
     */
    public function test_read_pay_item()
    {
        $payItem = PayItem::factory()->create();

        $dbPayItem = $this->payItemRepo->find($payItem->id);

        $dbPayItem = $dbPayItem->toArray();
        $this->assertModelData($payItem->toArray(), $dbPayItem);
    }

    /**
     * @test update
     */
    public function test_update_pay_item()
    {
        $payItem = PayItem::factory()->create();
        $fakePayItem = PayItem::factory()->make()->toArray();

        $updatedPayItem = $this->payItemRepo->update($fakePayItem, $payItem->id);

        $this->assertModelData($fakePayItem, $updatedPayItem->toArray());
        $dbPayItem = $this->payItemRepo->find($payItem->id);
        $this->assertModelData($fakePayItem, $dbPayItem->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_pay_item()
    {
        $payItem = PayItem::factory()->create();

        $resp = $this->payItemRepo->delete($payItem->id);

        $this->assertTrue($resp);
        $this->assertNull(PayItem::find($payItem->id), 'PayItem should not exist in DB');
    }
}
