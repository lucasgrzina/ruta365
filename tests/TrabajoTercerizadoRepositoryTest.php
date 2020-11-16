<?php

use App\TrabajoTercerizado;
use App\Repositories\TrabajoTercerizadoRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TrabajoTercerizadoRepositoryTest extends TestCase
{
    use MakeTrabajoTercerizadoTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var TrabajoTercerizadoRepository
     */
    protected $trabajoTercerizadoRepo;

    public function setUp()
    {
        parent::setUp();
        $this->trabajoTercerizadoRepo = App::make(TrabajoTercerizadoRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateTrabajoTercerizado()
    {
        $trabajoTercerizado = $this->fakeTrabajoTercerizadoData();
        $createdTrabajoTercerizado = $this->trabajoTercerizadoRepo->create($trabajoTercerizado);
        $createdTrabajoTercerizado = $createdTrabajoTercerizado->toArray();
        $this->assertArrayHasKey('id', $createdTrabajoTercerizado);
        $this->assertNotNull($createdTrabajoTercerizado['id'], 'Created TrabajoTercerizado must have id specified');
        $this->assertNotNull(TrabajoTercerizado::find($createdTrabajoTercerizado['id']), 'TrabajoTercerizado with given id must be in DB');
        $this->assertModelData($trabajoTercerizado, $createdTrabajoTercerizado);
    }

    /**
     * @test read
     */
    public function testReadTrabajoTercerizado()
    {
        $trabajoTercerizado = $this->makeTrabajoTercerizado();
        $dbTrabajoTercerizado = $this->trabajoTercerizadoRepo->find($trabajoTercerizado->id);
        $dbTrabajoTercerizado = $dbTrabajoTercerizado->toArray();
        $this->assertModelData($trabajoTercerizado->toArray(), $dbTrabajoTercerizado);
    }

    /**
     * @test update
     */
    public function testUpdateTrabajoTercerizado()
    {
        $trabajoTercerizado = $this->makeTrabajoTercerizado();
        $fakeTrabajoTercerizado = $this->fakeTrabajoTercerizadoData();
        $updatedTrabajoTercerizado = $this->trabajoTercerizadoRepo->update($fakeTrabajoTercerizado, $trabajoTercerizado->id);
        $this->assertModelData($fakeTrabajoTercerizado, $updatedTrabajoTercerizado->toArray());
        $dbTrabajoTercerizado = $this->trabajoTercerizadoRepo->find($trabajoTercerizado->id);
        $this->assertModelData($fakeTrabajoTercerizado, $dbTrabajoTercerizado->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteTrabajoTercerizado()
    {
        $trabajoTercerizado = $this->makeTrabajoTercerizado();
        $resp = $this->trabajoTercerizadoRepo->delete($trabajoTercerizado->id);
        $this->assertTrue($resp);
        $this->assertNull(TrabajoTercerizado::find($trabajoTercerizado->id), 'TrabajoTercerizado should not exist in DB');
    }
}
