<?php

use Faker\Factory as Faker;
use App\FormatType;
use App\Repositories\FormatTypeRepository;

trait MakeFormatTypeTrait
{
    /**
     * Create fake instance of FormatType and save it in database
     *
     * @param array $formatTypeFields
     * @return FormatType
     */
    public function makeFormatType($formatTypeFields = [])
    {
        /** @var FormatTypeRepository $formatTypeRepo */
        $formatTypeRepo = App::make(FormatTypeRepository::class);
        $theme = $this->fakeFormatTypeData($formatTypeFields);
        return $formatTypeRepo->create($theme);
    }

    /**
     * Get fake instance of FormatType
     *
     * @param array $formatTypeFields
     * @return FormatType
     */
    public function fakeFormatType($formatTypeFields = [])
    {
        return new FormatType($this->fakeFormatTypeData($formatTypeFields));
    }

    /**
     * Get fake data of FormatType
     *
     * @param array $postFields
     * @return array
     */
    public function fakeFormatTypeData($formatTypeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'icon' => $fake->word,
            'name' => $fake->word,
            'enabled' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $formatTypeFields);
    }
}
