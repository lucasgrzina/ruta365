<?php

use Faker\Factory as Faker;
use App\Producto;
use App\Repositories\ProductoRepository;

trait MakeProductoTrait
{
    /**
     * Create fake instance of Producto and save it in database
     *
     * @param array $productoFields
     * @return Producto
     */
    public function makeProducto($productoFields = [])
    {
        /** @var ProductoRepository $productoRepo */
        $productoRepo = App::make(ProductoRepository::class);
        $theme = $this->fakeProductoData($productoFields);
        return $productoRepo->create($theme);
    }

    /**
     * Get fake instance of Producto
     *
     * @param array $productoFields
     * @return Producto
     */
    public function fakeProducto($productoFields = [])
    {
        return new Producto($this->fakeProductoData($productoFields));
    }

    /**
     * Get fake data of Producto
     *
     * @param array $postFields
     * @return array
     */
    public function fakeProductoData($productoFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'seccion_id' => $fake->randomDigitNotNull,
            'nombre' => $fake->word,
            'imagen' => $fake->word,
            'codigo' => $fake->word,
            'precio' => $fake->word,
            'enabled' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $productoFields);
    }
}
