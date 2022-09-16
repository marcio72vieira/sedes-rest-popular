<?php

namespace App\Http\Requests;

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
            'cpf'                   => 'required|unique:users,cpf',
            'crn'                   => 'required',
            'telefone'              => 'required',
            'name'                  => 'bail|required|string',  // é o campo usuário
            'email'                 => 'bail|required|string|email|unique:users,email',
            'municipio_id'          => 'bail|required',
            'perfil'                => 'bail|required',
            'password'              => 'bail|required|confirmed',
            'password_confirmation' => 'bail|required'
        ];
    }
}
