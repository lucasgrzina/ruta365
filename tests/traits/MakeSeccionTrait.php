<?php

use Faker\Factory as Faker;
use App\Seccion;
use App\Repositories\SeccionRepository;

trait MakeSeccionTrait
{
    /**
     * Create fake instance of Seccion and save it in database
     *
     * @param array $seccionFields
     * @return Seccion
     */
    public function makeSeccion($seccionFields = [])
    {
        /** @var SeccionRepository $seccionRepo */
        $seccionRepo = App::make(SeccionRepository::class);
        $theme = $this->fakeSeccionData($seccionFields);
        return $seccionRepo->create($theme);
    }

    /**
     * Get fake instance of Seccion
     *
     * @param array $seccionFields
     * @return Seccion
     */
    public function fakeSeccion($seccionFields = [])
    {
        return new Seccion($this->fakeSeccionData($seccionFields));
    }

    /**
     * Get fake data of Seccion
     *
     * @param array $postFields
     * @return array
     */
    public function fakeSeccionData($seccionFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'nombre' => $fake->word,
            'categoria_id' => $fake->randomDigitNotNull,
            'orden' => $fake->randomDigitNotNull,
            'enabled' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $seccionFields);
    }
}
