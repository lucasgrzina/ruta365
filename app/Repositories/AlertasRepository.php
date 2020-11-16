<?php

namespace App\Repositories;

use App\Alertas;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AlertasRepository
 * @package App\Repositories
 * @version November 13, 2020, 10:07 am -03
 *
 * @method Alertas findWithoutFail($id, $columns = ['*'])
 * @method Alertas find($id, $columns = ['*'])
 * @method Alertas first($columns = ['*'])
*/
class AlertasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'registrado_id',
        'sucursal_id',
        'leido'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Alertas::class;
    }
}
