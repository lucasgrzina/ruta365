<?php

namespace App\Repositories;

use App\Materiales;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MaterialesRepository
 * @package App\Repositories
 * @version November 13, 2020, 3:42 pm -03
 *
 * @method Materiales findWithoutFail($id, $columns = ['*'])
 * @method Materiales find($id, $columns = ['*'])
 * @method Materiales first($columns = ['*'])
*/
class MaterialesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'sucursal_id',
        'tipo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Materiales::class;
    }
}
