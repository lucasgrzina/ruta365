<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PriceChannelCategoryApiTest extends TestCase
{
    use MakePriceChannelCategoryTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatePriceChannelCategory()
    {
        $priceChannelCategory = $this->fakePriceChannelCategoryData();
        $this->json('POST', '/api/v1/priceChannelCategories', $priceChannelCategory);

        $this->assertApiResponse($priceChannelCategory);
    }

    /**
     * @test
     */
    public function testReadPriceChannelCategory()
    {
        $priceChannelCategory = $this->makePriceChannelCategory();
        $this->json('GET', '/api/v1/priceChannelCategories/'.$priceChannelCategory->id);

        $this->assertApiResponse($priceChannelCategory->toArray());
    }

    /**
     * @test
     */
    public function testUpdatePriceChannelCategory()
    {
        $priceChannelCategory = $this->makePriceChannelCategory();
        $editedPriceChannelCategory = $this->fakePriceChannelCategoryData();

        $this->json('PUT', '/api/v1/priceChannelCategories/'.$priceChannelCategory->id, $editedPriceChannelCategory);

        $this->assertApiResponse($editedPriceChannelCategory);
    }

    /**
     * @test
     */
    public function testDeletePriceChannelCategory()
    {
        $priceChannelCategory = $this->makePriceChannelCategory();
        $this->json('DELETE', '/api/v1/priceChannelCategories/'.$priceChannelCategory->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/priceChannelCategories/'.$priceChannelCategory->id);

        $this->assertResponseStatus(404);
    }
}
