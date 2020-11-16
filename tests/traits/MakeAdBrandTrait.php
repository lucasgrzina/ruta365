<?php

use Faker\Factory as Faker;
use App\AdBrand;
use App\Repositories\AdBrandRepository;

trait MakeAdBrandTrait
{
    /**
     * Create fake instance of AdBrand and save it in database
     *
     * @param array $adBrandFields
     * @return AdBrand
     */
    public function makeAdBrand($adBrandFields = [])
    {
        /** @var AdBrandRepository $adBrandRepo */
        $adBrandRepo = App::make(AdBrandRepository::class);
        $theme = $this->fakeAdBrandData($adBrandFields);
        return $adBrandRepo->create($theme);
    }

    /**
     * Get fake instance of AdBrand
     *
     * @param array $adBrandFields
     * @return AdBrand
     */
    public function fakeAdBrand($adBrandFields = [])
    {
        return new AdBrand($this->fakeAdBrandData($adBrandFields));
    }

    /**
     * Get fake data of AdBrand
     *
     * @param array $postFields
     * @return array
     */
    public function fakeAdBrandData($adBrandFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'ad_id' => $fake->randomDigitNotNull,
            'brand_id' => $fake->randomDigitNotNull,
            'url_demo' => $fake->word,
            'icon_demo' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $adBrandFields);
    }
}
