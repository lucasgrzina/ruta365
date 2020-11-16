<?php

namespace App;

use App\Traits\UploadableTrait;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Yajra\Auditable\AuditableTrait;
//use Dimsav\Translatable\Translatable;

/**
 * Class Banners
 * @package App
 * @version November 11, 2020, 2:06 pm -03
 *
 * @property integer retail_id
 * @property string imagen_web
 * @property string imagen_mobile
 */
class Banners extends Model
{
    use SoftDeletes;

    use AuditableTrait;
    //use Translatable;
    use UploadableTrait;

    public $table = 'banners';
    
    /**
     * Translatable
     */

    //public $translatedAttributes = ['name'];

    /**
     * Uploadable
     *
     * files, targetDir, tmpDir, disk
     */

    public $files = ['imagen_web','imagen_mobile'];
    public $targetDir = 'banners';


    
    
    protected $dates = ['deleted_at'];

    
    public $fillable = [
        'retail_id',
        'imagen_web',
        'imagen_mobile',
        'enabled'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'retail_id' => 'integer',
        'imagen_web' => 'string',
        'imagen_mobile' => 'string',
        'enabled' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'retail_id' => 'required',
        'imagen_web' => 'required',
        'enabled' => 'boolean'
    ];

    /**
     * Appends Attributes
     *
     * @var array
     */
    protected $appends = ['imagen_web_url','imagen_mobile_url'];

    public function getImagenWebUrlAttribute($value) 
    {
        return $this->imagen_web ? \FUHelper::fullUrl($this->targetDir,$this->imagen_web) : null;
    }   

    public function getImagenMobileUrlAttribute($value) 
    {
        return $this->imagen_mobile ? \FUHelper::fullUrl($this->targetDir,$this->imagen_mobile) : null;
    }   

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
