<?php

namespace App\Repositories;

use App\Retails;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RetailsRepository
 * @package App\Repositories
 * @version November 3, 2020, 9:15 am -03
 *
 * @method Retails findWithoutFail($id, $columns = ['*'])
 * @method Retails find($id, $columns = ['*'])
 * @method Retails first($columns = ['*'])
*/
class RetailsRepository extends BaseRepository
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
        return Retails::class;
    }
}
