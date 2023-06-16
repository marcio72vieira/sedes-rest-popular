<?php

namespace App\Http\Requests;

use App\Rules\CpfValidateRule;
use Illuminate\Foundation\Http\FormRequest;

class NutricionistaUpdateRequest extends FormRequest
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
            'cpf'                   => ['bail', 'required', new CpfValidateRule()],    // Com regra de validação de CPF customizada
            'crn'                   => 'bail|required',
            'email'                 => 'bail|required',
            'telefone'              => 'required',
            //'empresa_id'          => 'bail|required',
            'ativo'                 => 'bail|required'

        ];
    }
}
