<?php

use Faker\Factory as Faker;
use App\Models\Settings;
use App\Repositories\RealEstateRepository;

trait MakeRealEstateTrait
{
    /**
     * Create fake instance of RealEstate and save it in database
     *
     * @param array $realEstateFields
     * @return Settings
     */
    public function makeRealEstate($realEstateFields = [])
    {
        /** @var RealEstateRepository $realEstateRepo */
        $realEstateRepo = App::make(RealEstateRepository::class);
        $theme = $this->fakeRealEstateData($realEstateFields);
        return $realEstateRepo->create($theme);
    }

    /**
     * Get fake instance of RealEstate
     *
     * @param array $realEstateFields
     * @return Settings
     */
    public function fakeRealEstate($realEstateFields = [])
    {
        return new Settings($this->fakeRealEstateData($realEstateFields));
    }

    /**
     * Get fake data of RealEstate
     *
     * @param array $postFields
     * @return array
     */
    public function fakeRealEstateData($realEstateFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'address_id' => $fake->randomDigitNotNull,
            'name' => $fake->word,
            'email' => $fake->word,
            'phone' => $fake->word,
            'language' => $fake->word,
            'logo' => $fake->word,
            'blank_pdf' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $realEstateFields);
    }
}
