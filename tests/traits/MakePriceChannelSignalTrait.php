<?php

use Faker\Factory as Faker;
use App\PriceChannelSignal;
use App\Repositories\PriceChannelSignalRepository;

trait MakePriceChannelSignalTrait
{
    /**
     * Create fake instance of PriceChannelSignal and save it in database
     *
     * @param array $priceChannelSignalFields
     * @return PriceChannelSignal
     */
    public function makePriceChannelSignal($priceChannelSignalFields = [])
    {
        /** @var PriceChannelSignalRepository $priceChannelSignalRepo */
        $priceChannelSignalRepo = App::make(PriceChannelSignalRepository::class);
        $theme = $this->fakePriceChannelSignalData($priceChannelSignalFields);
        return $priceChannelSignalRepo->create($theme);
    }

    /**
     * Get fake instance of PriceChannelSignal
     *
     * @param array $priceChannelSignalFields
     * @return PriceChannelSignal
     */
    public function fakePriceChannelSignal($priceChannelSignalFields = [])
    {
        return new PriceChannelSignal($this->fakePriceChannelSignalData($priceChannelSignalFields));
    }

    /**
     * Get fake data of PriceChannelSignal
     *
     * @param array $postFields
     * @return array
     */
    public function fakePriceChannelSignalData($priceChannelSignalFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'order' => $fake->randomDigitNotNull,
            'price_channel_category_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $priceChannelSignalFields);
    }
}
