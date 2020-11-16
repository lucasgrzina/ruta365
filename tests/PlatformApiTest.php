<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlatformApiTest extends TestCase
{
    use MakePlatformTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatePlatform()
    {
        $platform = $this->fakePlatformData();
        $this->json('POST', '/api/v1/platforms', $platform);

        $this->assertApiResponse($platform);
    }

    /**
     * @test
     */
    public function testReadPlatform()
    {
        $platform = $this->makePlatform();
        $this->json('GET', '/api/v1/platforms/'.$platform->id);

        $this->assertApiResponse($platform->toArray());
    }

    /**
     * @test
     */
    public function testUpdatePlatform()
    {
        $platform = $this->makePlatform();
        $editedPlatform = $this->fakePlatformData();

        $this->json('PUT', '/api/v1/platforms/'.$platform->id, $editedPlatform);

        $this->assertApiResponse($editedPlatform);
    }

    /**
     * @test
     */
    public function testDeletePlatform()
    {
        $platform = $this->makePlatform();
        $this->json('DELETE', '/api/v1/platforms/'.$platform->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/platforms/'.$platform->id);

        $this->assertResponseStatus(404);
    }
}
