<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Clientes;

class CUClientesRequest extends FormRequest
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
        $rules = Clientes::$rules;
        $rules['cuit'] = str_replace('{:id}', $this->get('id') , $rules['cuit']); 
        return $rules;
    }
}
