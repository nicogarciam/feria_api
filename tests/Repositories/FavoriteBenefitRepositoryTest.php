<?php namespace Tests\Repositories;

use App\Models\FavoriteBenefit;
use App\Repositories\FavoriteBenefitRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FavoriteBenefitRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FavoriteBenefitRepository
     */
    protected $favoriteBenefitRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->favoriteBenefitRepo = \App::make(FavoriteBenefitRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_favorite_benefit()
    {
        $favoriteBenefit = factory(FavoriteBenefit::class)->make()->toArray();

        $createdFavoriteBenefit = $this->favoriteBenefitRepo->create($favoriteBenefit);

        $createdFavoriteBenefit = $createdFavoriteBenefit->toArray();
        $this->assertArrayHasKey('id', $createdFavoriteBenefit);
        $this->assertNotNull($createdFavoriteBenefit['id'], 'Created FavoriteBenefit must have id specified');
        $this->assertNotNull(FavoriteBenefit::find($createdFavoriteBenefit['id']), 'FavoriteBenefit with given id must be in DB');
        $this->assertModelData($favoriteBenefit, $createdFavoriteBenefit);
    }

    /**
     * @test read
     */
    public function test_read_favorite_benefit()
    {
        $favoriteBenefit = factory(FavoriteBenefit::class)->create();

        $dbFavoriteBenefit = $this->favoriteBenefitRepo->find($favoriteBenefit->id);

        $dbFavoriteBenefit = $dbFavoriteBenefit->toArray();
        $this->assertModelData($favoriteBenefit->toArray(), $dbFavoriteBenefit);
    }

    /**
     * @test update
     */
    public function test_update_favorite_benefit()
    {
        $favoriteBenefit = factory(FavoriteBenefit::class)->create();
        $fakeFavoriteBenefit = factory(FavoriteBenefit::class)->make()->toArray();

        $updatedFavoriteBenefit = $this->favoriteBenefitRepo->update($fakeFavoriteBenefit, $favoriteBenefit->id);

        $this->assertModelData($fakeFavoriteBenefit, $updatedFavoriteBenefit->toArray());
        $dbFavoriteBenefit = $this->favoriteBenefitRepo->find($favoriteBenefit->id);
        $this->assertModelData($fakeFavoriteBenefit, $dbFavoriteBenefit->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_favorite_benefit()
    {
        $favoriteBenefit = factory(FavoriteBenefit::class)->create();

        $resp = $this->favoriteBenefitRepo->delete($favoriteBenefit->id);

        $this->assertTrue($resp);
        $this->assertNull(FavoriteBenefit::find($favoriteBenefit->id), 'FavoriteBenefit should not exist in DB');
    }
}
