<?php namespace Tests\Repositories;

use App\Models\Customer;
use App\Repositories\GuestRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class GuestRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var GuestRepository
     */
    protected $guestRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->guestRepo = \App::make(GuestRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_guest()
    {
        $guest = Customer::factory()->make()->toArray();

        $createdGuest = $this->guestRepo->create($guest);

        $createdGuest = $createdGuest->toArray();
        $this->assertArrayHasKey('id', $createdGuest);
        $this->assertNotNull($createdGuest['id'], 'Created Customer must have id specified');
        $this->assertNotNull(Customer::find($createdGuest['id']), 'Customer with given id must be in DB');
        $this->assertModelData($guest, $createdGuest);
    }

    /**
     * @test read
     */
    public function test_read_guest()
    {
        $guest = Customer::factory()->create();

        $dbGuest = $this->guestRepo->find($guest->id);

        $dbGuest = $dbGuest->toArray();
        $this->assertModelData($guest->toArray(), $dbGuest);
    }

    /**
     * @test update
     */
    public function test_update_guest()
    {
        $guest = Customer::factory()->create();
        $fakeGuest = Customer::factory()->make()->toArray();

        $updatedGuest = $this->guestRepo->update($fakeGuest, $guest->id);

        $this->assertModelData($fakeGuest, $updatedGuest->toArray());
        $dbGuest = $this->guestRepo->find($guest->id);
        $this->assertModelData($fakeGuest, $dbGuest->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_guest()
    {
        $guest = Customer::factory()->create();

        $resp = $this->guestRepo->delete($guest->id);

        $this->assertTrue($resp);
        $this->assertNull(Customer::find($guest->id), 'Customer should not exist in DB');
    }
}
