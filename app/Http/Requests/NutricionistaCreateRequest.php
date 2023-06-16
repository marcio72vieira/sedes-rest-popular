<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CpfValidateRule;

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
            'cpf'                   => ['bail', 'required', 'unique:nutricionistas,cpf', new CpfValidateRule()],    // Com regra de validação de CPF customizada
            'crn'                   => 'bail|required|unique:nutricionistas,crn',
            'email'                 => 'bail|required|string|email|unique:nutricionistas,email',
            'telefone'              => 'required',
            //'empresa_id'            => 'bail|required',
            'ativo'                 => 'bail|required'

        ];
    }
}
