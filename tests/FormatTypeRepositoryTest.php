<?php

use App\FormatType;
use App\Repositories\FormatTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FormatTypeRepositoryTest extends TestCase
{
    use MakeFormatTypeTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var FormatTypeRepository
     */
    protected $formatTypeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->formatTypeRepo = App::make(FormatTypeRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateFormatType()
    {
        $formatType = $this->fakeFormatTypeData();
        $createdFormatType = $this->formatTypeRepo->create($formatType);
        $createdFormatType = $createdFormatType->toArray();
        $this->assertArrayHasKey('id', $createdFormatType);
        $this->assertNotNull($createdFormatType['id'], 'Created FormatType must have id specified');
        $this->assertNotNull(FormatType::find($createdFormatType['id']), 'FormatType with given id must be in DB');
        $this->assertModelData($formatType, $createdFormatType);
    }

    /**
     * @test read
     */
    public function testReadFormatType()
    {
        $formatType = $this->makeFormatType();
        $dbFormatType = $this->formatTypeRepo->find($formatType->id);
        $dbFormatType = $dbFormatType->toArray();
        $this->assertModelData($formatType->toArray(), $dbFormatType);
    }

    /**
     * @test update
     */
    public function testUpdateFormatType()
    {
        $formatType = $this->makeFormatType();
        $fakeFormatType = $this->fakeFormatTypeData();
        $updatedFormatType = $this->formatTypeRepo->update($fakeFormatType, $formatType->id);
        $this->assertModelData($fakeFormatType, $updatedFormatType->toArray());
        $dbFormatType = $this->formatTypeRepo->find($formatType->id);
        $this->assertModelData($fakeFormatType, $dbFormatType->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteFormatType()
    {
        $formatType = $this->makeFormatType();
        $resp = $this->formatTypeRepo->delete($formatType->id);
        $this->assertTrue($resp);
        $this->assertNull(FormatType::find($formatType->id), 'FormatType should not exist in DB');
    }
}
