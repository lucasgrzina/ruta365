<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Sucursales;

class CUSucursalesRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Sucursales::$rules;
        $rules['nombre'] = str_replace('{:id}', $this->get('id') , $rules['nombre']); 
        $rules['nombre'] = str_replace('{:retail_id}', $this->get('retail_id') , $rules['nombre']); 

        $rules['codigo'] = str_replace('{:id}', $this->get('id') , $rules['codigo']); 
        $rules['codigo'] = str_replace('{:retail_id}', $this->get('retail_id') , $rules['codigo']);         
        return $rules;
    }
}
