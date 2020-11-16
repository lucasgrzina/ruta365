<?php

namespace App;

use App\Traits\UploadableTrait;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Yajra\Auditable\AuditableTrait;
//use Dimsav\Translatable\Translatable;

/**
 * Class Retails
 * @package App
 * @version November 3, 2020, 9:15 am -03
 *
 * @property string nombre
 * @property integer pais_id
 * @property string logo
 * @property string color_hexa
 */
class Retails extends Model
{
    use SoftDeletes;

    use AuditableTrait;
    //use Translatable;
    use UploadableTrait;

    public $table = 'retails';
    
    /**
     * Translatable
     */

    //public $translatedAttributes = ['name'];

    /**
     * Uploadable
     *
     * files, targetDir, tmpDir, disk
     */

    public $files = ['logo'];
    public $targetDir = 'retails';


    
    
    protected $dates = ['deleted_at'];

    
    public $fillable = [
        'nombre',
        'pais_id',
        'logo',
        'color_hexa',
        'enabled',
        'tipo',
        'cat_1_target_attach',
        'cat_2_target_attach',
        'cat_3_target_attach',
        'cat_4_target_attach',
        'cat_5_target_attach',
        'cat_1_puo',
        'cat_2_puo',
        'cat_3_puo',
        'cat_4_puo',
        'cat_5_puo',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nombre' => 'string',
        'pais_id' => 'integer',
        'logo' => 'string',
        'color_hexa' => 'string',
        'enabled' => 'boolean',
        'cat_1_target_attach' => 'float(5,2)',
        'cat_2_target_attach' => 'float(5,2)',
        'cat_3_target_attach' => 'float(5,2)',
        'cat_4_target_attach' => 'float(5,2)',
        'cat_5_target_attach' => 'float(5,2)',
        'cat_1_puo' => 'integer',
        'cat_2_puo' => 'integer',
        'cat_3_puo' => 'integer',
        'cat_4_puo' => 'integer',
        'cat_5_puo' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nombre' => 'required',
        'pais_id' => 'required',
        'logo' => 'required',
        'color_hexa' => 'required',
        'tipo' => 'required'
        //'enabled' => 'boolean'
    ];

    /**
     * Appends Attributes
     *
     * @var array
     */
    protected $appends = ['logo_url'];

    public function getLogoUrlAttribute($value) 
    {
        return $this->logo ? \FUHelper::fullUrl($this->targetDir,$this->logo) : null;
    }   

    public function pais()
    {
        return $this->belongsTo('App\Paises', 'pais_id');
    }

    public function usuarios()
    {
        return $this->hasMany('App\User', 'retail_id');
    }
    
    public function sucursales()
    {
        return $this->hasMany('App\Sucursales', 'retail_id');
    }

    public function banner()
    {
        return $this->hasOne('App\Banners', 'retail_id');
    }   
    
    public function premio()
    {
        return $this->hasOne('App\Premios', 'retail_id');
    }    
    
    public function mecanica()
    {
        return $this->hasOne('App\Mecanicas', 'retail_id');
    }        

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($model) 
        {
            //$model->sucursales()->delete();
            $model->banner()->delete();
            $model->premio()->delete();
            $model->mecanica()->delete();
            //$model->deleteTranslations();
            //$model->name = $model->id . '_' . $model->name;
            //$model->save();
        });        
    }    

}
