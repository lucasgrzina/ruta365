<?php

use App\ContactoCliente;
use App\Repositories\ContactoClienteRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactoClienteRepositoryTest extends TestCase
{
    use MakeContactoClienteTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ContactoClienteRepository
     */
    protected $contactoClienteRepo;

    public function setUp()
    {
        parent::setUp();
        $this->contactoClienteRepo = App::make(ContactoClienteRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateContactoCliente()
    {
        $contactoCliente = $this->fakeContactoClienteData();
        $createdContactoCliente = $this->contactoClienteRepo->create($contactoCliente);
        $createdContactoCliente = $createdContactoCliente->toArray();
        $this->assertArrayHasKey('id', $createdContactoCliente);
        $this->assertNotNull($createdContactoCliente['id'], 'Created ContactoCliente must have id specified');
        $this->assertNotNull(ContactoCliente::find($createdContactoCliente['id']), 'ContactoCliente with given id must be in DB');
        $this->assertModelData($contactoCliente, $createdContactoCliente);
    }

    /**
     * @test read
     */
    public function testReadContactoCliente()
    {
        $contactoCliente = $this->makeContactoCliente();
        $dbContactoCliente = $this->contactoClienteRepo->find($contactoCliente->id);
        $dbContactoCliente = $dbContactoCliente->toArray();
        $this->assertModelData($contactoCliente->toArray(), $dbContactoCliente);
    }

    /**
     * @test update
     */
    public function testUpdateContactoCliente()
    {
        $contactoCliente = $this->makeContactoCliente();
        $fakeContactoCliente = $this->fakeContactoClienteData();
        $updatedContactoCliente = $this->contactoClienteRepo->update($fakeContactoCliente, $contactoCliente->id);
        $this->assertModelData($fakeContactoCliente, $updatedContactoCliente->toArray());
        $dbContactoCliente = $this->contactoClienteRepo->find($contactoCliente->id);
        $this->assertModelData($fakeContactoCliente, $dbContactoCliente->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteContactoCliente()
    {
        $contactoCliente = $this->makeContactoCliente();
        $resp = $this->contactoClienteRepo->delete($contactoCliente->id);
        $this->assertTrue($resp);
        $this->assertNull(ContactoCliente::find($contactoCliente->id), 'ContactoCliente should not exist in DB');
    }
}
