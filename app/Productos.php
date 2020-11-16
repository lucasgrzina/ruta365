<?php

namespace App;

use App\Traits\UploadableTrait;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Yajra\Auditable\AuditableTrait;
//use Dimsav\Translatable\Translatable;

/**
 * Class Productos
 * @package App
 * @version November 12, 2020, 3:59 pm -03
 *
 * @property string nombre
 * @property string imagen
 * @property integer orden
 */
class Productos extends Model
{
    use SoftDeletes;

    use AuditableTrait;
    //use Translatable;
    use UploadableTrait;

    public $table = 'productos';
    
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
    public $targetDir = 'productos';


    
    
    protected $dates = ['deleted_at'];

    
    public $fillable = [
        'nombre',
        'imagen',
        'orden',
        'enabled'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nombre' => 'string',
        'imagen' => 'string',
        'orden' => 'integer',
        'enabled' => 'boolean'        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nombre' => 'required',
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
