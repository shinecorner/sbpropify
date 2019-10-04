<?php

use Faker\Factory as Faker;
use App\Models\ServiceRequest;
use App\Repositories\RequestRepository;

trait MakeServiceRequestTrait
{
    /**
     * Create fake instance of Request and save it in database
     *
     * @param array $serviceRequestFields
     * @return ServiceRequest
     */
    public function makeServiceRequest($serviceRequestFields = [])
    {
        /** @var RequestRepository $serviceRequestRepo */
        $serviceRequestRepo = App::make(RequestRepository::class);
        $theme = $this->fakeServiceRequestData($serviceRequestFields);
        return $serviceRequestRepo->create($theme);
    }

    /**
     * Get fake instance of Request
     *
     * @param array $serviceRequestFields
     * @return ServiceRequest
     */
    public function fakeServiceRequest($serviceRequestFields = [])
    {
        return new ServiceRequest($this->fakeServiceRequestData($serviceRequestFields));
    }

    /**
     * Get fake data of Request
     *
     * @param array $postFields
     * @return array
     */
    public function fakeServiceRequestData($serviceRequestFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'category_id' => $fake->randomDigitNotNull,
            'subject_id' => $fake->randomDigitNotNull,
            'tenant_id' => $fake->randomDigitNotNull,
            'agent_id' => $fake->randomDigitNotNull,
            'service_id' => $fake->randomDigitNotNull,
            'title' => $fake->word,
            'description' => $fake->text,
            'status' => $fake->randomDigitNotNull,
            'priority' => $fake->randomDigitNotNull,
            'due_date' => $fake->word,
            'defect_location' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $serviceRequestFields);
    }
}
