<?php

namespace App;

use Eloquent as Model;

class VentasProductos extends Model
{
    public $table = 'ventas_productos';
    
    public $fillable = [
        'venta_id',
        'producto_id',
        'cantidad',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'venta_id'      => 'integer',
        'producto_id'   => 'integer',
        'cantidad'      => 'integer',        
    ];

   
    public static $rules = [];  

    public function venta()
    {
        return $this->belongsTo('App\Ventas', 'venta_id');
    }

    public function producto()
    {
        return $this->belongsTo('App\Productos', 'producto_id');
    }

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
