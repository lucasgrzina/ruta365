<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ComprasApiTest extends TestCase
{
    use MakeComprasTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCompras()
    {
        $compras = $this->fakeComprasData();
        $this->json('POST', '/api/v1/compras', $compras);

        $this->assertApiResponse($compras);
    }

    /**
     * @test
     */
    public function testReadCompras()
    {
        $compras = $this->makeCompras();
        $this->json('GET', '/api/v1/compras/'.$compras->id);

        $this->assertApiResponse($compras->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCompras()
    {
        $compras = $this->makeCompras();
        $editedCompras = $this->fakeComprasData();

        $this->json('PUT', '/api/v1/compras/'.$compras->id, $editedCompras);

        $this->assertApiResponse($editedCompras);
    }

    /**
     * @test
     */
    public function testDeleteCompras()
    {
        $compras = $this->makeCompras();
        $this->json('DELETE', '/api/v1/compras/'.$compras->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/compras/'.$compras->id);

        $this->assertResponseStatus(404);
    }
}
