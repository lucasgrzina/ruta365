<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TrabajoTercerizadoApiTest extends TestCase
{
    use MakeTrabajoTercerizadoTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateTrabajoTercerizado()
    {
        $trabajoTercerizado = $this->fakeTrabajoTercerizadoData();
        $this->json('POST', '/api/v1/trabajoTercerizados', $trabajoTercerizado);

        $this->assertApiResponse($trabajoTercerizado);
    }

    /**
     * @test
     */
    public function testReadTrabajoTercerizado()
    {
        $trabajoTercerizado = $this->makeTrabajoTercerizado();
        $this->json('GET', '/api/v1/trabajoTercerizados/'.$trabajoTercerizado->id);

        $this->assertApiResponse($trabajoTercerizado->toArray());
    }

    /**
     * @test
     */
    public function testUpdateTrabajoTercerizado()
    {
        $trabajoTercerizado = $this->makeTrabajoTercerizado();
        $editedTrabajoTercerizado = $this->fakeTrabajoTercerizadoData();

        $this->json('PUT', '/api/v1/trabajoTercerizados/'.$trabajoTercerizado->id, $editedTrabajoTercerizado);

        $this->assertApiResponse($editedTrabajoTercerizado);
    }

    /**
     * @test
     */
    public function testDeleteTrabajoTercerizado()
    {
        $trabajoTercerizado = $this->makeTrabajoTercerizado();
        $this->json('DELETE', '/api/v1/trabajoTercerizados/'.$trabajoTercerizado->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/trabajoTercerizados/'.$trabajoTercerizado->id);

        $this->assertResponseStatus(404);
    }
}
