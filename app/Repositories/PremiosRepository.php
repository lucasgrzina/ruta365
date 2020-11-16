<?php

namespace App\Repositories;

use App\Premios;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PremiosRepository
 * @package App\Repositories
 * @version November 12, 2020, 3:01 pm -03
 *
 * @method Premios findWithoutFail($id, $columns = ['*'])
 * @method Premios find($id, $columns = ['*'])
 * @method Premios first($columns = ['*'])
*/
class PremiosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'retail_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Premios::class;
    }
}
