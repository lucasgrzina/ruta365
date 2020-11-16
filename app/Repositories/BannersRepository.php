<?php

namespace App\Repositories;

use App\Banners;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BannersRepository
 * @package App\Repositories
 * @version November 11, 2020, 2:06 pm -03
 *
 * @method Banners findWithoutFail($id, $columns = ['*'])
 * @method Banners find($id, $columns = ['*'])
 * @method Banners first($columns = ['*'])
*/
class BannersRepository extends BaseRepository
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
        return Banners::class;
    }
}
