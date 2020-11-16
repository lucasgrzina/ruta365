<?php

namespace App;

use Eloquent as Model;


class Configuraciones extends Model
{
    public $table = 'configuraciones';

    
    public $fillable = [
        'clave',
        'valor',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'clave' => 'required',
    ];

    /**
     * Appends Attributes
     *
     * @var array
     */

    protected static function boot()
    {
        parent::boot();

        /*static::deleted(function ($model) 
        {
            $model->deleteTranslations();
            $model->name = $model->id . '_' . $model->name;
            $model->save();
        });*/        
    }    

}
