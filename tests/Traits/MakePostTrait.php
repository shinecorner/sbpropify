<?php

use Faker\Factory as Faker;
use App\Models\Pinboard;
use App\Repositories\PinboardRepository;

trait MakePostTrait
{
    /**
     * Create fake instance of Post and save it in database
     *
     * @param array $postFields
     * @return Pinboard
     */
    public function makePost($postFields = [])
    {
        /** @var PinboardRepository $postRepo */
        $postRepo = App::make(PinboardRepository::class);
        $theme = $this->fakePostData($postFields);
        return $postRepo->create($theme);
    }

    /**
     * Get fake instance of Post
     *
     * @param array $postFields
     * @return Pinboard
     */
    public function fakePost($postFields = [])
    {
        return new Pinboard($this->fakePostData($postFields));
    }

    /**
     * Get fake data of Post
     *
     * @param array $postFields
     * @return array
     */
    public function fakePostData($postFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->randomDigitNotNull,
            'type' => $fake->randomDigitNotNull,
            'status' => $fake->randomDigitNotNull,
            'visibility' => $fake->randomDigitNotNull,
            'content' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $postFields);
    }
}
