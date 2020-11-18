<?php

namespace App\Repositories;

use App\Ventas;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class VentasRepository
 * @package App\Repositories
 * @version November 18, 2020, 9:24 am -03
 *
 * @method Ventas findWithoutFail($id, $columns = ['*'])
 * @method Ventas find($id, $columns = ['*'])
 * @method Ventas first($columns = ['*'])
*/
class VentasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'sucursal_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Ventas::class;
    }
}
