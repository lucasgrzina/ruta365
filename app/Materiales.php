<?php

namespace App;

use App\Traits\UploadableTrait;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Yajra\Auditable\AuditableTrait;
//use Dimsav\Translatable\Translatable;

/**
 * Class Materiales
 * @package App
 * @version November 13, 2020, 3:42 pm -03
 *
 * @property integer user_id
 * @property integer sucursal_id
 * @property char tipo
 * @property string imagen
 * @property string descripcion
 */
class Materiales extends Model
{
    use SoftDeletes;

    use AuditableTrait;
    //use Translatable;
    use UploadableTrait;

    public $table = 'materiales';
    
    /**
     * Translatable
     */

    //public $translatedAttributes = ['name'];

    /**
     * Uploadable
     *
     * files, targetDir, tmpDir, disk
     */

    public $files = ['imagen'];
    public $targetDir = 'materiales';


    
    
    protected $dates = ['deleted_at'];

    
    public $fillable = [
        'user_id',
        'sucursal_id',
        'tipo',
        'imagen',
        'descripcion',
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
        'tipo' => 'string',
        'imagen' => 'string',
        'descripcion' => 'string',
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
        'tipo' => 'required',
        'imagen' => 'required',
        //'enabled' => 'boolean'
    ];

    /**
     * Appends Attributes
     *
     * @var array
     */
    protected $appends = ['imagen_url'];

    public function getImagenUrlAttribute($value) 
    {
        return $this->imagen ? \FUHelper::fullUrl($this->targetDir,$this->imagen) : null;
    }
    
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
