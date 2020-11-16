<?php

namespace App\Repositories;

use App\Sucursales;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SucursalesRepository
 * @package App\Repositories
 * @version November 4, 2020, 9:18 am -03
 *
 * @method Sucursales findWithoutFail($id, $columns = ['*'])
 * @method Sucursales find($id, $columns = ['*'])
 * @method Sucursales first($columns = ['*'])
*/
class SucursalesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombre',
        'codigo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Sucursales::class;
    }
}
