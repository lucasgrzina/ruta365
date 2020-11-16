<?php

namespace App\Repositories;

use App\Paises;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PaisesRepository
 * @package App\Repositories
 * @version November 3, 2020, 8:44 am -03
 *
 * @method Paises findWithoutFail($id, $columns = ['*'])
 * @method Paises find($id, $columns = ['*'])
 * @method Paises first($columns = ['*'])
*/
class PaisesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombre' => 'like'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Paises::class;
    }
}
