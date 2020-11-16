<?php

use App\Platform;
use App\Repositories\PlatformRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlatformRepositoryTest extends TestCase
{
    use MakePlatformTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var PlatformRepository
     */
    protected $platformRepo;

    public function setUp()
    {
        parent::setUp();
        $this->platformRepo = App::make(PlatformRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatePlatform()
    {
        $platform = $this->fakePlatformData();
        $createdPlatform = $this->platformRepo->create($platform);
        $createdPlatform = $createdPlatform->toArray();
        $this->assertArrayHasKey('id', $createdPlatform);
        $this->assertNotNull($createdPlatform['id'], 'Created Platform must have id specified');
        $this->assertNotNull(Platform::find($createdPlatform['id']), 'Platform with given id must be in DB');
        $this->assertModelData($platform, $createdPlatform);
    }

    /**
     * @test read
     */
    public function testReadPlatform()
    {
        $platform = $this->makePlatform();
        $dbPlatform = $this->platformRepo->find($platform->id);
        $dbPlatform = $dbPlatform->toArray();
        $this->assertModelData($platform->toArray(), $dbPlatform);
    }

    /**
     * @test update
     */
    public function testUpdatePlatform()
    {
        $platform = $this->makePlatform();
        $fakePlatform = $this->fakePlatformData();
        $updatedPlatform = $this->platformRepo->update($fakePlatform, $platform->id);
        $this->assertModelData($fakePlatform, $updatedPlatform->toArray());
        $dbPlatform = $this->platformRepo->find($platform->id);
        $this->assertModelData($fakePlatform, $dbPlatform->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletePlatform()
    {
        $platform = $this->makePlatform();
        $resp = $this->platformRepo->delete($platform->id);
        $this->assertTrue($resp);
        $this->assertNull(Platform::find($platform->id), 'Platform should not exist in DB');
    }
}
