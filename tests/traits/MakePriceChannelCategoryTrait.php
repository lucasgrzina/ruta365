<?php

use Faker\Factory as Faker;
use App\PriceChannelCategory;
use App\Repositories\PriceChannelCategoryRepository;

trait MakePriceChannelCategoryTrait
{
    /**
     * Create fake instance of PriceChannelCategory and save it in database
     *
     * @param array $priceChannelCategoryFields
     * @return PriceChannelCategory
     */
    public function makePriceChannelCategory($priceChannelCategoryFields = [])
    {
        /** @var PriceChannelCategoryRepository $priceChannelCategoryRepo */
        $priceChannelCategoryRepo = App::make(PriceChannelCategoryRepository::class);
        $theme = $this->fakePriceChannelCategoryData($priceChannelCategoryFields);
        return $priceChannelCategoryRepo->create($theme);
    }

    /**
     * Get fake instance of PriceChannelCategory
     *
     * @param array $priceChannelCategoryFields
     * @return PriceChannelCategory
     */
    public function fakePriceChannelCategory($priceChannelCategoryFields = [])
    {
        return new PriceChannelCategory($this->fakePriceChannelCategoryData($priceChannelCategoryFields));
    }

    /**
     * Get fake data of PriceChannelCategory
     *
     * @param array $postFields
     * @return array
     */
    public function fakePriceChannelCategoryData($priceChannelCategoryFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'color' => $fake->word,
            'order' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $priceChannelCategoryFields);
    }
}
