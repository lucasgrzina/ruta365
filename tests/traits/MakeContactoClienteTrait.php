<?php

use Faker\Factory as Faker;
use App\ContactoCliente;
use App\Repositories\ContactoClienteRepository;

trait MakeContactoClienteTrait
{
    /**
     * Create fake instance of ContactoCliente and save it in database
     *
     * @param array $contactoClienteFields
     * @return ContactoCliente
     */
    public function makeContactoCliente($contactoClienteFields = [])
    {
        /** @var ContactoClienteRepository $contactoClienteRepo */
        $contactoClienteRepo = App::make(ContactoClienteRepository::class);
        $theme = $this->fakeContactoClienteData($contactoClienteFields);
        return $contactoClienteRepo->create($theme);
    }

    /**
     * Get fake instance of ContactoCliente
     *
     * @param array $contactoClienteFields
     * @return ContactoCliente
     */
    public function fakeContactoCliente($contactoClienteFields = [])
    {
        return new ContactoCliente($this->fakeContactoClienteData($contactoClienteFields));
    }

    /**
     * Get fake data of ContactoCliente
     *
     * @param array $postFields
     * @return array
     */
    public function fakeContactoClienteData($contactoClienteFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'cliente_id' => $fake->randomDigitNotNull,
            'nombre' => $fake->word,
            'apellido' => $fake->word,
            'email' => $fake->word,
            'nro_telefono' => $fake->word,
            'nro_celular' => $fake->word,
            'pais_id' => $fake->randomDigitNotNull,
            'puesto' => $fake->word,
            'marca_proyecto' => $fake->text,
            'direccion_postal' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $contactoClienteFields);
    }
}
