<?php

namespace Tests\Traits;

use App;
use Faker\Factory as Faker;
use App\Models\Address;
use App\Repositories\AddressRepository;

/**
 * Trait MakeAddressTrait
 * @package Tests\traits
 */
trait MakeAddressTrait
{
    /**
     * @param array $addressFields
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function makeAddress($addressFields = [])
    {
        /** @var AddressRepository $addressRepo */
        $addressRepo = App::make(AddressRepository::class);
        $theme = $this->fakeAddressData($addressFields);
        return $addressRepo->create($theme);
    }

    /**
     * Get fake instance of Address
     *
     * @param array $addressFields
     * @return Address
     */
    public function fakeAddress($addressFields = [])
    {
        return new Address($this->fakeAddressData($addressFields));
    }

    /**
     * @param array $addressFields
     * @return array
     */
    public function fakeAddressData($addressFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'country_id' => 210,
            'state_id' => $fake->randomDigitNotNull,
            'city' => $fake->word,
            'street' => $fake->streetAddress,
            'street_nr' => $fake->buildingNumber,
            'zip' => $fake->word
        ], $addressFields);
    }
}

