<?php

use App\PriceChannelSignal;
use App\Repositories\PriceChannelSignalRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PriceChannelSignalRepositoryTest extends TestCase
{
    use MakePriceChannelSignalTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var PriceChannelSignalRepository
     */
    protected $priceChannelSignalRepo;

    public function setUp()
    {
        parent::setUp();
        $this->priceChannelSignalRepo = App::make(PriceChannelSignalRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatePriceChannelSignal()
    {
        $priceChannelSignal = $this->fakePriceChannelSignalData();
        $createdPriceChannelSignal = $this->priceChannelSignalRepo->create($priceChannelSignal);
        $createdPriceChannelSignal = $createdPriceChannelSignal->toArray();
        $this->assertArrayHasKey('id', $createdPriceChannelSignal);
        $this->assertNotNull($createdPriceChannelSignal['id'], 'Created PriceChannelSignal must have id specified');
        $this->assertNotNull(PriceChannelSignal::find($createdPriceChannelSignal['id']), 'PriceChannelSignal with given id must be in DB');
        $this->assertModelData($priceChannelSignal, $createdPriceChannelSignal);
    }

    /**
     * @test read
     */
    public function testReadPriceChannelSignal()
    {
        $priceChannelSignal = $this->makePriceChannelSignal();
        $dbPriceChannelSignal = $this->priceChannelSignalRepo->find($priceChannelSignal->id);
        $dbPriceChannelSignal = $dbPriceChannelSignal->toArray();
        $this->assertModelData($priceChannelSignal->toArray(), $dbPriceChannelSignal);
    }

    /**
     * @test update
     */
    public function testUpdatePriceChannelSignal()
    {
        $priceChannelSignal = $this->makePriceChannelSignal();
        $fakePriceChannelSignal = $this->fakePriceChannelSignalData();
        $updatedPriceChannelSignal = $this->priceChannelSignalRepo->update($fakePriceChannelSignal, $priceChannelSignal->id);
        $this->assertModelData($fakePriceChannelSignal, $updatedPriceChannelSignal->toArray());
        $dbPriceChannelSignal = $this->priceChannelSignalRepo->find($priceChannelSignal->id);
        $this->assertModelData($fakePriceChannelSignal, $dbPriceChannelSignal->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletePriceChannelSignal()
    {
        $priceChannelSignal = $this->makePriceChannelSignal();
        $resp = $this->priceChannelSignalRepo->delete($priceChannelSignal->id);
        $this->assertTrue($resp);
        $this->assertNull(PriceChannelSignal::find($priceChannelSignal->id), 'PriceChannelSignal should not exist in DB');
    }
}
