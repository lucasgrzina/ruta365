<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FormatTypeApiTest extends TestCase
{
    use MakeFormatTypeTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateFormatType()
    {
        $formatType = $this->fakeFormatTypeData();
        $this->json('POST', '/api/v1/formatTypes', $formatType);

        $this->assertApiResponse($formatType);
    }

    /**
     * @test
     */
    public function testReadFormatType()
    {
        $formatType = $this->makeFormatType();
        $this->json('GET', '/api/v1/formatTypes/'.$formatType->id);

        $this->assertApiResponse($formatType->toArray());
    }

    /**
     * @test
     */
    public function testUpdateFormatType()
    {
        $formatType = $this->makeFormatType();
        $editedFormatType = $this->fakeFormatTypeData();

        $this->json('PUT', '/api/v1/formatTypes/'.$formatType->id, $editedFormatType);

        $this->assertApiResponse($editedFormatType);
    }

    /**
     * @test
     */
    public function testDeleteFormatType()
    {
        $formatType = $this->makeFormatType();
        $this->json('DELETE', '/api/v1/formatTypes/'.$formatType->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/formatTypes/'.$formatType->id);

        $this->assertResponseStatus(404);
    }
}
