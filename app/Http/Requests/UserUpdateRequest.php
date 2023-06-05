<?php

namespace App\Http\Requests;

use App\Rules\CpfValidateRule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'cpf'                   => 'required',
            'cpf'                   => new CpfValidateRule(),       // Valida o CPF com com regra de validação customizada
            'crn'                   => 'required_if:perfil,"nut"',  // campo requerido se perfil for do tipo "nut"
            'telefone'              => 'required',
            'name'                  => 'bail|required|string',  // é o campo usuário
            'email'                 => 'bail|required',
            'municipio_id'          => 'bail|required',
            'perfil'                => 'bail|required',
            'password'              => 'bail|confirmed',
            'password_confirmation' => 'bail|required_with:password'
        ];
    }

    public function messages()
    {
        return [
            'crn.required_if' => 'Este campo é obrigatório para usuários com perfil de Nutricionista',
        ];
    }
}
