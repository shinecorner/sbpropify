<?php
declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Traits\MakeAddressTrait;
use App\Models\User;

/**
 * Class AddressApiTest
 */
class AddressApiTest extends TestCase
{
    use MakeAddressTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateAddress()
    {
        $address = $this->fakeAddressData();

        $this->response = $this->actingAs($this->user)
            ->withSession(['test' => 'session'])
            ->json('POST', '/api/v1/addresses', $address);

        $this->assertApiResponse($address);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testReadAddress()
    {
        $address = $this->makeAddress();

        $this->response = $this->actingAs($this->user)
            ->withSession(['test' => 'session'])
            ->json('GET', '/api/v1/addresses/' . $address->id);

        $this->assertApiResponse($address->toArray());
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testUpdateAddress()
    {
        $address = $this->makeAddress();
        $editedAddress = $this->fakeAddressData();

        $this->response = $this->actingAs($this->user)
            ->withSession(['test' => 'session'])
            ->json('PUT', '/api/v1/addresses/' . $address->id, $editedAddress);

        $this->assertApiResponse($editedAddress);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testDeleteAddress()
    {
        $address = $this->makeAddress();
        $this->response = $this->actingAs($this->user)
            ->withSession(['test' => 'session'])
            ->json('DELETE', '/api/v1/addresses/' . $address->id);

        $this->assertApiSuccess();

        $this->response = $this->actingAs($this->user)
            ->withSession(['test' => 'session'])
            ->json('GET', '/api/v1/addresses/' . $address->id);

        $this->response->assertStatus(404);
    }
}
