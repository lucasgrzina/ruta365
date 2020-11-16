<?php

namespace App;

use App\Traits\UploadableTrait;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Yajra\Auditable\AuditableTrait;
//use Dimsav\Translatable\Translatable;

/**
 * Class Sucursales
 * @package App
 * @version November 4, 2020, 9:18 am -03
 *
 * @property string nombre
 * @property string codigo
 * @property integer retail_id
 * @property string observaciones
 */
class Sucursales extends Model
{
    use SoftDeletes;

    use AuditableTrait;
    //use Translatable;
    //use UploadableTrait;

    public $table = 'sucursales';
    
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
    //public $targetDir = 'sucursales';


    
    
    protected $dates = ['deleted_at'];

    
    public $fillable = [
        'nombre',
        'codigo',
        'retail_id',
        'observaciones',
        'enabled',
        'target_attach',
        'piso_unidades_office',
        'categoria_cluster',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nombre' => 'string',
        'codigo' => 'string',
        'retail_id' => 'integer',
        'observaciones' => 'string',
        'enabled' => 'boolean',
        'target_attach' => 'float(5,2)',
        'piso_unidades_office' => 'integer',
        'categoria_cluster' => 'integer',        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nombre' => 'required|unique:sucursales,nombre,{:id},id,retail_id,{:retail_id}',
        'retail_id' => 'required',
        'codigo' => 'required|unique:sucursales,codigo,{:id},id,retail_id,{:retail_id}',        
        //'enabled' => 'boolean'
    ];

    /**
     * Appends Attributes
     *
     * @var array
     */
    //protected $appends = ['the_file_url'];

    /*public function getTheFileUrlAttribute($value) 
    {
        return \FUHelper::fullUrl($this->targetDir,$this->the_file);
    }*/   

    public function retail()
    {
        return $this->belongsTo('App\Retails', 'retail_id');
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
