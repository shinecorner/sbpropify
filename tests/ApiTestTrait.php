<?php
declare(strict_types=1);

namespace Tests;

/**
 * Trait ApiTestTrait
 * @package Tests
 */
trait ApiTestTrait
{
    /**
     * @var
     */
    var $response;

    /**
     * @param array $actualData
     */
    public function assertApiResponse(Array $actualData)
    {
        $this->assertApiSuccess();

        $response = json_decode($this->response->getContent(), true);
        $responseData = $response['data'];

        $this->assertNotEmpty($responseData['id']);
        $this->assertModelData($actualData, $responseData);
    }

    /**
     *
     */
    public function assertApiSuccess()
    {
        $this->response->assertSuccessful();
        $this->response->assertJson(['success' => true]);
    }

    /**
     * @param array $actualData
     * @param array $expectedData
     */
    public function assertModelData(Array $actualData, Array $expectedData)
    {
        foreach ($actualData as $key => $value) {
            $this->assertEquals($actualData[$key], $expectedData[$key]);
        }
    }
}
