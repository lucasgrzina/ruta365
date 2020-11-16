<?php

namespace App\Repositories;

use App\Contactos;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ContactosRepository
 * @package App\Repositories
 * @version November 12, 2020, 4:54 pm -03
 *
 * @method Contactos findWithoutFail($id, $columns = ['*'])
 * @method Contactos find($id, $columns = ['*'])
 * @method Contactos first($columns = ['*'])
*/
class ContactosRepository extends BaseRepository
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
        return Contactos::class;
    }
}
