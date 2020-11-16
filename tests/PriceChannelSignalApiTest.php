<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PriceChannelSignalApiTest extends TestCase
{
    use MakePriceChannelSignalTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatePriceChannelSignal()
    {
        $priceChannelSignal = $this->fakePriceChannelSignalData();
        $this->json('POST', '/api/v1/priceChannelSignals', $priceChannelSignal);

        $this->assertApiResponse($priceChannelSignal);
    }

    /**
     * @test
     */
    public function testReadPriceChannelSignal()
    {
        $priceChannelSignal = $this->makePriceChannelSignal();
        $this->json('GET', '/api/v1/priceChannelSignals/'.$priceChannelSignal->id);

        $this->assertApiResponse($priceChannelSignal->toArray());
    }

    /**
     * @test
     */
    public function testUpdatePriceChannelSignal()
    {
        $priceChannelSignal = $this->makePriceChannelSignal();
        $editedPriceChannelSignal = $this->fakePriceChannelSignalData();

        $this->json('PUT', '/api/v1/priceChannelSignals/'.$priceChannelSignal->id, $editedPriceChannelSignal);

        $this->assertApiResponse($editedPriceChannelSignal);
    }

    /**
     * @test
     */
    public function testDeletePriceChannelSignal()
    {
        $priceChannelSignal = $this->makePriceChannelSignal();
        $this->json('DELETE', '/api/v1/priceChannelSignals/'.$priceChannelSignal->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/priceChannelSignals/'.$priceChannelSignal->id);

        $this->assertResponseStatus(404);
    }
}
