<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdBrandApiTest extends TestCase
{
    use MakeAdBrandTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateAdBrand()
    {
        $adBrand = $this->fakeAdBrandData();
        $this->json('POST', '/api/v1/adBrands', $adBrand);

        $this->assertApiResponse($adBrand);
    }

    /**
     * @test
     */
    public function testReadAdBrand()
    {
        $adBrand = $this->makeAdBrand();
        $this->json('GET', '/api/v1/adBrands/'.$adBrand->id);

        $this->assertApiResponse($adBrand->toArray());
    }

    /**
     * @test
     */
    public function testUpdateAdBrand()
    {
        $adBrand = $this->makeAdBrand();
        $editedAdBrand = $this->fakeAdBrandData();

        $this->json('PUT', '/api/v1/adBrands/'.$adBrand->id, $editedAdBrand);

        $this->assertApiResponse($editedAdBrand);
    }

    /**
     * @test
     */
    public function testDeleteAdBrand()
    {
        $adBrand = $this->makeAdBrand();
        $this->json('DELETE', '/api/v1/adBrands/'.$adBrand->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/adBrands/'.$adBrand->id);

        $this->assertResponseStatus(404);
    }
}
