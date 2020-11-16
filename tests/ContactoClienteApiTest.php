<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactoClienteApiTest extends TestCase
{
    use MakeContactoClienteTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateContactoCliente()
    {
        $contactoCliente = $this->fakeContactoClienteData();
        $this->json('POST', '/api/v1/contactoClientes', $contactoCliente);

        $this->assertApiResponse($contactoCliente);
    }

    /**
     * @test
     */
    public function testReadContactoCliente()
    {
        $contactoCliente = $this->makeContactoCliente();
        $this->json('GET', '/api/v1/contactoClientes/'.$contactoCliente->id);

        $this->assertApiResponse($contactoCliente->toArray());
    }

    /**
     * @test
     */
    public function testUpdateContactoCliente()
    {
        $contactoCliente = $this->makeContactoCliente();
        $editedContactoCliente = $this->fakeContactoClienteData();

        $this->json('PUT', '/api/v1/contactoClientes/'.$contactoCliente->id, $editedContactoCliente);

        $this->assertApiResponse($editedContactoCliente);
    }

    /**
     * @test
     */
    public function testDeleteContactoCliente()
    {
        $contactoCliente = $this->makeContactoCliente();
        $this->json('DELETE', '/api/v1/contactoClientes/'.$contactoCliente->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/contactoClientes/'.$contactoCliente->id);

        $this->assertResponseStatus(404);
    }
}
