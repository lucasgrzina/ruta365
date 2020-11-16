<?php

use Faker\Factory as Faker;
use App\TrabajoTercerizado;
use App\Repositories\TrabajoTercerizadoRepository;

trait MakeTrabajoTercerizadoTrait
{
    /**
     * Create fake instance of TrabajoTercerizado and save it in database
     *
     * @param array $trabajoTercerizadoFields
     * @return TrabajoTercerizado
     */
    public function makeTrabajoTercerizado($trabajoTercerizadoFields = [])
    {
        /** @var TrabajoTercerizadoRepository $trabajoTercerizadoRepo */
        $trabajoTercerizadoRepo = App::make(TrabajoTercerizadoRepository::class);
        $theme = $this->fakeTrabajoTercerizadoData($trabajoTercerizadoFields);
        return $trabajoTercerizadoRepo->create($theme);
    }

    /**
     * Get fake instance of TrabajoTercerizado
     *
     * @param array $trabajoTercerizadoFields
     * @return TrabajoTercerizado
     */
    public function fakeTrabajoTercerizado($trabajoTercerizadoFields = [])
    {
        return new TrabajoTercerizado($this->fakeTrabajoTercerizadoData($trabajoTercerizadoFields));
    }

    /**
     * Get fake data of TrabajoTercerizado
     *
     * @param array $postFields
     * @return array
     */
    public function fakeTrabajoTercerizadoData($trabajoTercerizadoFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'usuario_id' => $fake->randomDigitNotNull,
            'usuario_id' => $fake->word,
            'presupuesto_id' => $fake->randomDigitNotNull,
            'titulo' => $fake->word,
            'descripcion' => $fake->text,
            'representante_id' => $fake->randomDigitNotNull,
            'fecha_ini' => $fake->date('Y-m-d H:i:s'),
            'fecha_fin' => $fake->date('Y-m-d H:i:s'),
            'tiempo' => $fake->word,
            'rubro_id' => $fake->randomDigitNotNull,
            'proveedor_id' => $fake->randomDigitNotNull,
            'contacto_prov' => $fake->word,
            'presupuesto_prov' => $fake->word,
            'monto' => $fake->word,
            'moneda_id' => $fake->randomDigitNotNull,
            'fecha_pago' => $fake->word,
            'status_id' => $fake->randomDigitNotNull,
            'observaciones' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $trabajoTercerizadoFields);
    }
}
