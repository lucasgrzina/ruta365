<?php

use Faker\Factory as Faker;
use App\Compras;
use App\Repositories\ComprasRepository;

trait MakeComprasTrait
{
    /**
     * Create fake instance of Compras and save it in database
     *
     * @param array $comprasFields
     * @return Compras
     */
    public function makeCompras($comprasFields = [])
    {
        /** @var ComprasRepository $comprasRepo */
        $comprasRepo = App::make(ComprasRepository::class);
        $theme = $this->fakeComprasData($comprasFields);
        return $comprasRepo->create($theme);
    }

    /**
     * Get fake instance of Compras
     *
     * @param array $comprasFields
     * @return Compras
     */
    public function fakeCompras($comprasFields = [])
    {
        return new Compras($this->fakeComprasData($comprasFields));
    }

    /**
     * Get fake data of Compras
     *
     * @param array $postFields
     * @return array
     */
    public function fakeComprasData($comprasFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'fecha' => $fake->word,
            'empresa' => $fake->word,
            'proveedor_id' => $fake->randomDigitNotNull,
            'detalle' => $fake->text,
            'neto_0' => $fake->word,
            'neto_105' => $fake->word,
            'neto_21' => $fake->word,
            'neto_total' => $fake->word,
            'iva_105' => $fake->word,
            'iva_21' => $fake->word,
            'iva_total' => $fake->word,
            'total' => $fake->word,
            'perc_iibb_caba' => $fake->word,
            'perc_iibb_prov' => $fake->word,
            'perc_ganancias' => $fake->word,
            'perc_iva' => $fake->word,
            'perc_otras' => $fake->word,
            'total' => $fake->word,
            'nro_factura' => $fake->word,
            'forma_pago_id' => $fake->randomDigitNotNull,
            'fecha_compra_efectiva' => $fake->word,
            'tc' => $fake->word,
            'venta_id' => $fake->randomDigitNotNull,
            'fecha_pago_real' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $comprasFields);
    }
}
