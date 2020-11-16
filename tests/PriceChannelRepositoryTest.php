<?php

use App\PriceChannel;
use App\Repositories\PriceChannelRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PriceChannelRepositoryTest extends TestCase
{
    use MakePriceChannelTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var PriceChannelRepository
     */
    protected $priceChannelRepo;

    public function setUp()
    {
        parent::setUp();
        $this->priceChannelRepo = App::make(PriceChannelRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatePriceChannel()
    {
        $priceChannel = $this->fakePriceChannelData();
        $createdPriceChannel = $this->priceChannelRepo->create($priceChannel);
        $createdPriceChannel = $createdPriceChannel->toArray();
        $this->assertArrayHasKey('id', $createdPriceChannel);
        $this->assertNotNull($createdPriceChannel['id'], 'Created PriceChannel must have id specified');
        $this->assertNotNull(PriceChannel::find($createdPriceChannel['id']), 'PriceChannel with given id must be in DB');
        $this->assertModelData($priceChannel, $createdPriceChannel);
    }

    /**
     * @test read
     */
    public function testReadPriceChannel()
    {
        $priceChannel = $this->makePriceChannel();
        $dbPriceChannel = $this->priceChannelRepo->find($priceChannel->id);
        $dbPriceChannel = $dbPriceChannel->toArray();
        $this->assertModelData($priceChannel->toArray(), $dbPriceChannel);
    }

    /**
     * @test update
     */
    public function testUpdatePriceChannel()
    {
        $priceChannel = $this->makePriceChannel();
        $fakePriceChannel = $this->fakePriceChannelData();
        $updatedPriceChannel = $this->priceChannelRepo->update($fakePriceChannel, $priceChannel->id);
        $this->assertModelData($fakePriceChannel, $updatedPriceChannel->toArray());
        $dbPriceChannel = $this->priceChannelRepo->find($priceChannel->id);
        $this->assertModelData($fakePriceChannel, $dbPriceChannel->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletePriceChannel()
    {
        $priceChannel = $this->makePriceChannel();
        $resp = $this->priceChannelRepo->delete($priceChannel->id);
        $this->assertTrue($resp);
        $this->assertNull(PriceChannel::find($priceChannel->id), 'PriceChannel should not exist in DB');
    }
}
