<?php

namespace App\Repositories;

use App\Clientes;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ClientesRepository
 * @package App\Repositories
 * @version August 11, 2020, 3:55 pm -03
 *
 * @method Clientes findWithoutFail($id, $columns = ['*'])
 * @method Clientes find($id, $columns = ['*'])
 * @method Clientes first($columns = ['*'])
*/
class ClientesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'razon_social' => 'like',
        'cuit' => 'like',
        'nombre_fantasia' => 'like'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Clientes::class;
    }
}
