<?php

use Faker\Factory as Faker;
use App\Platform;
use App\Repositories\PlatformRepository;

trait MakePlatformTrait
{
    /**
     * Create fake instance of Platform and save it in database
     *
     * @param array $platformFields
     * @return Platform
     */
    public function makePlatform($platformFields = [])
    {
        /** @var PlatformRepository $platformRepo */
        $platformRepo = App::make(PlatformRepository::class);
        $theme = $this->fakePlatformData($platformFields);
        return $platformRepo->create($theme);
    }

    /**
     * Get fake instance of Platform
     *
     * @param array $platformFields
     * @return Platform
     */
    public function fakePlatform($platformFields = [])
    {
        return new Platform($this->fakePlatformData($platformFields));
    }

    /**
     * Get fake data of Platform
     *
     * @param array $postFields
     * @return array
     */
    public function fakePlatformData($platformFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'slug' => $fake->word,
            'short_name' => $fake->word,
            'light_icon' => $fake->word,
            'dark_icon' => $fake->word,
            'description' => $fake->text,
            'order' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $platformFields);
    }
}
