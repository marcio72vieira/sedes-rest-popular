<?php

namespace App\Http\Requests;

use App\Rules\CpfValidateRule;
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
            'cpf'                   => 'required|unique:nutricionistas,cpf',
            'cpf'                   => new CpfValidateRule(),       // Valida o CPF com com regra de validação customizada
            'crn'                   => 'bail|required',
            'email'                 => 'bail|required|string|email|unique:nutricionistas,email',
            'telefone'              => 'required',
            //'empresa_id'            => 'bail|required',
            'ativo'                 => 'bail|required'

        ];
    }
}
