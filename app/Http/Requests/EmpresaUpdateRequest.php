<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaUpdateRequest extends FormRequest
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
            'razaosocial' => 'bail|required|min:5',
            'nomefantasia' => 'bail|required|min:2',
            'cnpj' => 'bail|required|min:10',
            'titular' => 'bail|required',
            'cargotitular' => 'bail|required',
            'logradouro' => 'bail|required',
            'numero' => 'bail|required',
            //'complemento' => 'bail|required',
            'municipio' => 'bail|required',
            'bairro' => 'bail|required',
            'cep' => 'bail|required',
            'email' => 'bail|required',
            'celular' => 'bail|required',
            'fone' => 'bail|required',
            'ativo' => 'bail|required'
        ];
    }
}
