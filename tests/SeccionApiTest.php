<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SeccionApiTest extends TestCase
{
    use MakeSeccionTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateSeccion()
    {
        $seccion = $this->fakeSeccionData();
        $this->json('POST', '/api/v1/seccions', $seccion);

        $this->assertApiResponse($seccion);
    }

    /**
     * @test
     */
    public function testReadSeccion()
    {
        $seccion = $this->makeSeccion();
        $this->json('GET', '/api/v1/seccions/'.$seccion->id);

        $this->assertApiResponse($seccion->toArray());
    }

    /**
     * @test
     */
    public function testUpdateSeccion()
    {
        $seccion = $this->makeSeccion();
        $editedSeccion = $this->fakeSeccionData();

        $this->json('PUT', '/api/v1/seccions/'.$seccion->id, $editedSeccion);

        $this->assertApiResponse($editedSeccion);
    }

    /**
     * @test
     */
    public function testDeleteSeccion()
    {
        $seccion = $this->makeSeccion();
        $this->json('DELETE', '/api/v1/seccions/'.$seccion->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/seccions/'.$seccion->id);

        $this->assertResponseStatus(404);
    }
}
