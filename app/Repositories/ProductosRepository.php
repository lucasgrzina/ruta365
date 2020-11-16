<?php

namespace App\Repositories;

use App\Productos;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProductosRepository
 * @package App\Repositories
 * @version November 12, 2020, 3:59 pm -03
 *
 * @method Productos findWithoutFail($id, $columns = ['*'])
 * @method Productos find($id, $columns = ['*'])
 * @method Productos first($columns = ['*'])
*/
class ProductosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombre'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Productos::class;
    }
}
