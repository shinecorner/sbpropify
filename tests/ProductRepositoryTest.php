<?php

use App\Models\Product;
use App\Repositories\ListingRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductRepositoryTest extends TestCase
{
    use MakeProductTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ListingRepository
     */
    protected $productRepo;

    public function setUp()
    {
        parent::setUp();
        $this->productRepo = App::make(ListingRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateProduct()
    {
        $product = $this->fakeProductData();
        $createdProduct = $this->productRepo->create($product);
        $createdProduct = $createdProduct->toArray();
        $this->assertArrayHasKey('id', $createdProduct);
        $this->assertNotNull($createdProduct['id'], 'Created Listing must have id specified');
        $this->assertNotNull(Product::find($createdProduct['id']), 'Listing with given id must be in DB');
        $this->assertModelData($product, $createdProduct);
    }

    /**
     * @test read
     */
    public function testReadProduct()
    {
        $product = $this->makeProduct();
        $dbProduct = $this->productRepo->find($product->id);
        $dbProduct = $dbProduct->toArray();
        $this->assertModelData($product->toArray(), $dbProduct);
    }

    /**
     * @test update
     */
    public function testUpdateProduct()
    {
        $product = $this->makeProduct();
        $fakeProduct = $this->fakeProductData();
        $updatedProduct = $this->productRepo->update($fakeProduct, $product->id);
        $this->assertModelData($fakeProduct, $updatedProduct->toArray());
        $dbProduct = $this->productRepo->find($product->id);
        $this->assertModelData($fakeProduct, $dbProduct->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteProduct()
    {
        $product = $this->makeProduct();
        $resp = $this->productRepo->delete($product->id);
        $this->assertTrue($resp);
        $this->assertNull(Product::find($product->id), 'Listing should not exist in DB');
    }
}
