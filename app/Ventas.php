<?php

namespace App;

use App\Traits\UploadableTrait;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Yajra\Auditable\AuditableTrait;
//use Dimsav\Translatable\Translatable;

/**
 * Class Ventas
 * @package App
 * @version November 18, 2020, 9:24 am -03
 *
 * @property integer sucursal_id
 * @property integer cantidad_dispositivos
 */
class Ventas extends Model
{
    use SoftDeletes;

    use AuditableTrait;
    //use Translatable;
    //use UploadableTrait;

    public $table = 'ventas';
    
    /**
     * Translatable
     */

    //public $translatedAttributes = ['name'];

    /**
     * Uploadable
     *
     * files, targetDir, tmpDir, disk
     */

    //public $files = ['the_file'];
    //public $targetDir = 'ventas';


    
    
    protected $dates = ['deleted_at'];

    
    public $fillable = [
        'sucursal_id',
        'cantidad_dispositivos',
        //'enabled'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'sucursal_id' => 'integer',
        'cantidad_dispositivos' => 'integer',
        //'enabled' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'sucursal_id' => 'required',
        'cantidad_dispositivos' => 'required',
        //'enabled' => 'boolean'
    ];

   

    public function productos()
    {
        return $this->hasMany('App\VentasProductos', 'venta_id');
    }

    public function sucursal()
    {
        return $this->belongsTo('App\Sucursales', 'sucursal_id');
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
