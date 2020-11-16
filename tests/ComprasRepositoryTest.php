<?php

use App\Compras;
use App\Repositories\ComprasRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ComprasRepositoryTest extends TestCase
{
    use MakeComprasTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ComprasRepository
     */
    protected $comprasRepo;

    public function setUp()
    {
        parent::setUp();
        $this->comprasRepo = App::make(ComprasRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCompras()
    {
        $compras = $this->fakeComprasData();
        $createdCompras = $this->comprasRepo->create($compras);
        $createdCompras = $createdCompras->toArray();
        $this->assertArrayHasKey('id', $createdCompras);
        $this->assertNotNull($createdCompras['id'], 'Created Compras must have id specified');
        $this->assertNotNull(Compras::find($createdCompras['id']), 'Compras with given id must be in DB');
        $this->assertModelData($compras, $createdCompras);
    }

    /**
     * @test read
     */
    public function testReadCompras()
    {
        $compras = $this->makeCompras();
        $dbCompras = $this->comprasRepo->find($compras->id);
        $dbCompras = $dbCompras->toArray();
        $this->assertModelData($compras->toArray(), $dbCompras);
    }

    /**
     * @test update
     */
    public function testUpdateCompras()
    {
        $compras = $this->makeCompras();
        $fakeCompras = $this->fakeComprasData();
        $updatedCompras = $this->comprasRepo->update($fakeCompras, $compras->id);
        $this->assertModelData($fakeCompras, $updatedCompras->toArray());
        $dbCompras = $this->comprasRepo->find($compras->id);
        $this->assertModelData($fakeCompras, $dbCompras->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCompras()
    {
        $compras = $this->makeCompras();
        $resp = $this->comprasRepo->delete($compras->id);
        $this->assertTrue($resp);
        $this->assertNull(Compras::find($compras->id), 'Compras should not exist in DB');
    }
}
