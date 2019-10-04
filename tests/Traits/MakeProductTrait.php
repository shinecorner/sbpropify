<?php

use Faker\Factory as Faker;
use App\Models\Product;
use App\Repositories\ListingRepository;

trait MakeProductTrait
{
    /**
     * Create fake instance of Listing and save it in database
     *
     * @param array $productFields
     * @return Product
     */
    public function makeProduct($productFields = [])
    {
        /** @var ListingRepository $productRepo */
        $productRepo = App::make(ListingRepository::class);
        $theme = $this->fakeProductData($productFields);
        return $productRepo->create($theme);
    }

    /**
     * Get fake instance of Listing
     *
     * @param array $productFields
     * @return Product
     */
    public function fakeProduct($productFields = [])
    {
        return new Product($this->fakeProductData($productFields));
    }

    /**
     * Get fake data of Listing
     *
     * @param array $postFields
     * @return array
     */
    public function fakeProductData($productFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->randomDigitNotNull,
            'type' => $fake->randomDigitNotNull,
            'status' => $fake->randomDigitNotNull,
            'visibility' => $fake->randomDigitNotNull,
            'content' => $fake->text,
            'contact' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $productFields);
    }
}
