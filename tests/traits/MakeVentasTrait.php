<?php

use Faker\Factory as Faker;
use App\Ventas;
use App\Repositories\VentasRepository;

trait MakeVentasTrait
{
    /**
     * Create fake instance of Ventas and save it in database
     *
     * @param array $ventasFields
     * @return Ventas
     */
    public function makeVentas($ventasFields = [])
    {
        /** @var VentasRepository $ventasRepo */
        $ventasRepo = App::make(VentasRepository::class);
        $theme = $this->fakeVentasData($ventasFields);
        return $ventasRepo->create($theme);
    }

    /**
     * Get fake instance of Ventas
     *
     * @param array $ventasFields
     * @return Ventas
     */
    public function fakeVentas($ventasFields = [])
    {
        return new Ventas($this->fakeVentasData($ventasFields));
    }

    /**
     * Get fake data of Ventas
     *
     * @param array $postFields
     * @return array
     */
    public function fakeVentasData($ventasFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'nro_factura' => $fake->word,
            'fecha' => $fake->word,
            'cliente_id' => $fake->randomDigitNotNull,
            'detalle' => $fake->text,
            'neto_0' => $fake->word,
            'neto_105' => $fake->word,
            'neto_21' => $fake->word,
            'neto_total' => $fake->word,
            'iva_105' => $fake->word,
            'iva_21' => $fake->word,
            'total' => $fake->word,
            'iva_total' => $fake->word,
            'tc' => $fake->word,
            'vendedor_id' => $fake->randomDigitNotNull,
            'observaciones' => $fake->text,
            'porc_comision' => $fake->word,
            'importe_com_vta' => $fake->word,
            'fecha_cobro_factura' => $fake->word,
            'fecha_liquidacion' => $fake->word,
            'tasa_vigente' => $fake->word,
            'estado_id' => $fake->randomDigitNotNull,
            'remito' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $ventasFields);
    }
}
