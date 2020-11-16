<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PriceChannelApiTest extends TestCase
{
    use MakePriceChannelTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatePriceChannel()
    {
        $priceChannel = $this->fakePriceChannelData();
        $this->json('POST', '/api/v1/priceChannels', $priceChannel);

        $this->assertApiResponse($priceChannel);
    }

    /**
     * @test
     */
    public function testReadPriceChannel()
    {
        $priceChannel = $this->makePriceChannel();
        $this->json('GET', '/api/v1/priceChannels/'.$priceChannel->id);

        $this->assertApiResponse($priceChannel->toArray());
    }

    /**
     * @test
     */
    public function testUpdatePriceChannel()
    {
        $priceChannel = $this->makePriceChannel();
        $editedPriceChannel = $this->fakePriceChannelData();

        $this->json('PUT', '/api/v1/priceChannels/'.$priceChannel->id, $editedPriceChannel);

        $this->assertApiResponse($editedPriceChannel);
    }

    /**
     * @test
     */
    public function testDeletePriceChannel()
    {
        $priceChannel = $this->makePriceChannel();
        $this->json('DELETE', '/api/v1/priceChannels/'.$priceChannel->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/priceChannels/'.$priceChannel->id);

        $this->assertResponseStatus(404);
    }
}
