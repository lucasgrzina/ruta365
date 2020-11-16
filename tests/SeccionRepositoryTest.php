<?php

use App\Seccion;
use App\Repositories\SeccionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SeccionRepositoryTest extends TestCase
{
    use MakeSeccionTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var SeccionRepository
     */
    protected $seccionRepo;

    public function setUp()
    {
        parent::setUp();
        $this->seccionRepo = App::make(SeccionRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateSeccion()
    {
        $seccion = $this->fakeSeccionData();
        $createdSeccion = $this->seccionRepo->create($seccion);
        $createdSeccion = $createdSeccion->toArray();
        $this->assertArrayHasKey('id', $createdSeccion);
        $this->assertNotNull($createdSeccion['id'], 'Created Seccion must have id specified');
        $this->assertNotNull(Seccion::find($createdSeccion['id']), 'Seccion with given id must be in DB');
        $this->assertModelData($seccion, $createdSeccion);
    }

    /**
     * @test read
     */
    public function testReadSeccion()
    {
        $seccion = $this->makeSeccion();
        $dbSeccion = $this->seccionRepo->find($seccion->id);
        $dbSeccion = $dbSeccion->toArray();
        $this->assertModelData($seccion->toArray(), $dbSeccion);
    }

    /**
     * @test update
     */
    public function testUpdateSeccion()
    {
        $seccion = $this->makeSeccion();
        $fakeSeccion = $this->fakeSeccionData();
        $updatedSeccion = $this->seccionRepo->update($fakeSeccion, $seccion->id);
        $this->assertModelData($fakeSeccion, $updatedSeccion->toArray());
        $dbSeccion = $this->seccionRepo->find($seccion->id);
        $this->assertModelData($fakeSeccion, $dbSeccion->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteSeccion()
    {
        $seccion = $this->makeSeccion();
        $resp = $this->seccionRepo->delete($seccion->id);
        $this->assertTrue($resp);
        $this->assertNull(Seccion::find($seccion->id), 'Seccion should not exist in DB');
    }
}
