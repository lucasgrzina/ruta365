<?php

use Faker\Factory as Faker;
use App\PriceChannel;
use App\Repositories\PriceChannelRepository;

trait MakePriceChannelTrait
{
    /**
     * Create fake instance of PriceChannel and save it in database
     *
     * @param array $priceChannelFields
     * @return PriceChannel
     */
    public function makePriceChannel($priceChannelFields = [])
    {
        /** @var PriceChannelRepository $priceChannelRepo */
        $priceChannelRepo = App::make(PriceChannelRepository::class);
        $theme = $this->fakePriceChannelData($priceChannelFields);
        return $priceChannelRepo->create($theme);
    }

    /**
     * Get fake instance of PriceChannel
     *
     * @param array $priceChannelFields
     * @return PriceChannel
     */
    public function fakePriceChannel($priceChannelFields = [])
    {
        return new PriceChannel($this->fakePriceChannelData($priceChannelFields));
    }

    /**
     * Get fake data of PriceChannel
     *
     * @param array $postFields
     * @return array
     */
    public function fakePriceChannelData($priceChannelFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'price_channel_id' => $fake->randomDigitNotNull,
            'year' => $fake->randomDigitNotNull,
            'week' => $fake->randomDigitNotNull,
            'file' => $fake->word,
            'filename' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $priceChannelFields);
    }
}
