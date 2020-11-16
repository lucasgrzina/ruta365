<?php

use App\AdBrand;
use App\Repositories\AdBrandRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdBrandRepositoryTest extends TestCase
{
    use MakeAdBrandTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var AdBrandRepository
     */
    protected $adBrandRepo;

    public function setUp()
    {
        parent::setUp();
        $this->adBrandRepo = App::make(AdBrandRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateAdBrand()
    {
        $adBrand = $this->fakeAdBrandData();
        $createdAdBrand = $this->adBrandRepo->create($adBrand);
        $createdAdBrand = $createdAdBrand->toArray();
        $this->assertArrayHasKey('id', $createdAdBrand);
        $this->assertNotNull($createdAdBrand['id'], 'Created AdBrand must have id specified');
        $this->assertNotNull(AdBrand::find($createdAdBrand['id']), 'AdBrand with given id must be in DB');
        $this->assertModelData($adBrand, $createdAdBrand);
    }

    /**
     * @test read
     */
    public function testReadAdBrand()
    {
        $adBrand = $this->makeAdBrand();
        $dbAdBrand = $this->adBrandRepo->find($adBrand->id);
        $dbAdBrand = $dbAdBrand->toArray();
        $this->assertModelData($adBrand->toArray(), $dbAdBrand);
    }

    /**
     * @test update
     */
    public function testUpdateAdBrand()
    {
        $adBrand = $this->makeAdBrand();
        $fakeAdBrand = $this->fakeAdBrandData();
        $updatedAdBrand = $this->adBrandRepo->update($fakeAdBrand, $adBrand->id);
        $this->assertModelData($fakeAdBrand, $updatedAdBrand->toArray());
        $dbAdBrand = $this->adBrandRepo->find($adBrand->id);
        $this->assertModelData($fakeAdBrand, $dbAdBrand->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteAdBrand()
    {
        $adBrand = $this->makeAdBrand();
        $resp = $this->adBrandRepo->delete($adBrand->id);
        $this->assertTrue($resp);
        $this->assertNull(AdBrand::find($adBrand->id), 'AdBrand should not exist in DB');
    }
}
