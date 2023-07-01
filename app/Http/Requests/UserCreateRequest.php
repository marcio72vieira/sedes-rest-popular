<?php

namespace App\Http\Requests;

use App\Rules\CpfValidateRule;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'cpf'                   => ['bail', 'required', 'unique:users,cpf', new CpfValidateRule()],    // Com regra de validação de CPF customizada,
            'crn'                   => 'exclude_if:perfil,"adm"|required_if:perfil,"nut"|unique:users,crn',  // campo requerido se perfil for do tipo "nut"
            'telefone'              => 'required',
            'name'                  => 'bail|required|string',  // é o campo usuário
            'email'                 => 'bail|required|string|email|unique:users,email',
            'municipio_id'          => 'bail|required',
            'perfil'                => 'bail|required',
            'password'              => 'bail|required|confirmed',
            'password_confirmation' => 'bail|required'
        ];
    }

    public function messages()
    {
        return [
            'crn.required_if' => 'Este campo é obrigatório para usuários com perfil de Nutricionista',
        ];
    }
}
