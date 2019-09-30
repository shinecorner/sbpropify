<?php

use App\Models\Settings;
use App\Repositories\SettingsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RealEstateRepositoryTest extends TestCase
{
    use MakeRealEstateTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var SettingsRepository
     */
    protected $realEstateRepo;

    public function setUp()
    {
        parent::setUp();
        $this->realEstateRepo = App::make(SettingsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateRealEstate()
    {
        $realEstate = $this->fakeRealEstateData();
        $createdRealEstate = $this->realEstateRepo->create($realEstate);
        $createdRealEstate = $createdRealEstate->toArray();
        $this->assertArrayHasKey('id', $createdRealEstate);
        $this->assertNotNull($createdRealEstate['id'], 'Created Settings must have id specified');
        $this->assertNotNull(Settings::find($createdRealEstate['id']), 'Settings with given id must be in DB');
        $this->assertModelData($realEstate, $createdRealEstate);
    }

    /**
     * @test read
     */
    public function testReadRealEstate()
    {
        $realEstate = $this->makeRealEstate();
        $dbRealEstate = $this->realEstateRepo->find($realEstate->id);
        $dbRealEstate = $dbRealEstate->toArray();
        $this->assertModelData($realEstate->toArray(), $dbRealEstate);
    }

    /**
     * @test update
     */
    public function testUpdateRealEstate()
    {
        $realEstate = $this->makeRealEstate();
        $fakeRealEstate = $this->fakeRealEstateData();
        $updatedRealEstate = $this->realEstateRepo->update($fakeRealEstate, $realEstate->id);
        $this->assertModelData($fakeRealEstate, $updatedRealEstate->toArray());
        $dbRealEstate = $this->realEstateRepo->find($realEstate->id);
        $this->assertModelData($fakeRealEstate, $dbRealEstate->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteRealEstate()
    {
        $realEstate = $this->makeRealEstate();
        $resp = $this->realEstateRepo->delete($realEstate->id);
        $this->assertTrue($resp);
        $this->assertNull(Settings::find($realEstate->id), 'Settings should not exist in DB');
    }
}
