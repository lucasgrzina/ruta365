<?php

use App\PriceChannelCategory;
use App\Repositories\PriceChannelCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PriceChannelCategoryRepositoryTest extends TestCase
{
    use MakePriceChannelCategoryTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var PriceChannelCategoryRepository
     */
    protected $priceChannelCategoryRepo;

    public function setUp()
    {
        parent::setUp();
        $this->priceChannelCategoryRepo = App::make(PriceChannelCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatePriceChannelCategory()
    {
        $priceChannelCategory = $this->fakePriceChannelCategoryData();
        $createdPriceChannelCategory = $this->priceChannelCategoryRepo->create($priceChannelCategory);
        $createdPriceChannelCategory = $createdPriceChannelCategory->toArray();
        $this->assertArrayHasKey('id', $createdPriceChannelCategory);
        $this->assertNotNull($createdPriceChannelCategory['id'], 'Created PriceChannelCategory must have id specified');
        $this->assertNotNull(PriceChannelCategory::find($createdPriceChannelCategory['id']), 'PriceChannelCategory with given id must be in DB');
        $this->assertModelData($priceChannelCategory, $createdPriceChannelCategory);
    }

    /**
     * @test read
     */
    public function testReadPriceChannelCategory()
    {
        $priceChannelCategory = $this->makePriceChannelCategory();
        $dbPriceChannelCategory = $this->priceChannelCategoryRepo->find($priceChannelCategory->id);
        $dbPriceChannelCategory = $dbPriceChannelCategory->toArray();
        $this->assertModelData($priceChannelCategory->toArray(), $dbPriceChannelCategory);
    }

    /**
     * @test update
     */
    public function testUpdatePriceChannelCategory()
    {
        $priceChannelCategory = $this->makePriceChannelCategory();
        $fakePriceChannelCategory = $this->fakePriceChannelCategoryData();
        $updatedPriceChannelCategory = $this->priceChannelCategoryRepo->update($fakePriceChannelCategory, $priceChannelCategory->id);
        $this->assertModelData($fakePriceChannelCategory, $updatedPriceChannelCategory->toArray());
        $dbPriceChannelCategory = $this->priceChannelCategoryRepo->find($priceChannelCategory->id);
        $this->assertModelData($fakePriceChannelCategory, $dbPriceChannelCategory->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletePriceChannelCategory()
    {
        $priceChannelCategory = $this->makePriceChannelCategory();
        $resp = $this->priceChannelCategoryRepo->delete($priceChannelCategory->id);
        $this->assertTrue($resp);
        $this->assertNull(PriceChannelCategory::find($priceChannelCategory->id), 'PriceChannelCategory should not exist in DB');
    }
}
