<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestauranteCreateRequest extends FormRequest
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
            'identificacao' => 'bail|required',
            'logradouro' => 'bail|required',
            'numero' => 'bail|required',
            //'complemento' => 'bail|required',
            'municipio_id' => 'bail|required',
            'bairro_id' => 'bail|required',
            'cep' => 'bail|required',
            'empresa_id' => 'bail|required',
            'nutricionista_id' => 'bail|required',
            'user_id' => 'bail|required',
            'ativo' => 'bail|required'
        ];
    }
}
