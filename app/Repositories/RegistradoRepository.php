<?php

namespace App\Repositories;


use App\Registrado;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RegisteredRepository
 * @package App\Repositories
 * @version November 10, 2017, 8:03 pm UTC
 *
 * @method Registered findWithoutFail($id, $columns = ['*'])
 * @method Registered find($id, $columns = ['*'])
 * @method Registered first($columns = ['*'])
*/
class RegistradoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'usuario' => 'like',
        'email' => 'like'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Registrado::class;
    }
}
