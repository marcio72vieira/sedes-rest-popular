<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NutricionistaCreateRequest extends FormRequest
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
        return [
            'nomecompleto'          => 'bail|required|string',
            'cpf'                   => 'required|unique:nutricionista,cpf',
            'crn'                   => 'bail|required',
            'email'                 => 'bail|required|string|email|unique:users,email',
            'telefone'              => 'required',
            //'empresa_id'            => 'bail|required',
            'ativo'                 => 'bail|required'
            
        ];
    }
}
