<?php

namespace App;

use App\Traits\UploadableTrait;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Yajra\Auditable\AuditableTrait;
//use Dimsav\Translatable\Translatable;

/**
 * Class Alertas
 * @package App
 * @version November 13, 2020, 10:07 am -03
 *
 * @property integer registrado_id
 * @property integer sucursal_id
 * @property string descripcion
 * @property boolean leido
 * @property string observaciones
 */
class Alertas extends Model
{
    use SoftDeletes;

    use AuditableTrait;
    //use Translatable;
    //use UploadableTrait;

    public $table = 'alertas';
    
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
    //public $targetDir = 'alertas';


    
    
    protected $dates = ['deleted_at'];

    
    public $fillable = [
        'user_id',
        'sucursal_id',
        'descripcion',
        'leido',
        'observaciones',
        //'enabled'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'sucursal_id' => 'integer',
        'descripcion' => 'string',
        'leido' => 'boolean',
        'observaciones' => 'string',
        //'enabled' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'sucursal_id' => 'required',
        'leido' => 'boolean',
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

    public function usuario()
    {
        return $this->belongsTo('App\User', 'user_id');
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
