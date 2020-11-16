<?php

namespace App\Repositories;

use App\Mecanicas;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MecanicasRepository
 * @package App\Repositories
 * @version November 12, 2020, 4:27 pm -03
 *
 * @method Mecanicas findWithoutFail($id, $columns = ['*'])
 * @method Mecanicas find($id, $columns = ['*'])
 * @method Mecanicas first($columns = ['*'])
*/
class MecanicasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Mecanicas::class;
    }
}
