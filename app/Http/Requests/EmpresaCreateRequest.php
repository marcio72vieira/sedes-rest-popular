<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaCreateRequest extends FormRequest
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
            'cnpj' => 'bail|required|min:10|unique:empresas,cnpj',
            'codigocnae' => 'bail|required',
            'documentocnpj' => 'bail|required|mimes:pdf|max:2048',
            'titularum' => 'bail|required',
            'cargotitum' => 'bail|required',
            //'titulardois' => 'bail|required',
            //'cargotitdois' => 'bail|required',
            //'banco_id' => 'bail|required',
            'agencia' => 'bail|required',
            'conta' => 'bail|required',
            'logradouro' => 'bail|required',
            'numero' => 'bail|required',
            //'complemento' => 'bail|required',
            'municipio_id' => 'bail|required',
            'bairro_id' => 'bail|required',
            'cep' => 'bail|required',
            'emailum' => 'bail|required',
            //'emaildois' => 'bail|required',
            'celular' => 'bail|required',
            //'foneum' => 'bail|required',
            //'fonedois' => 'bail|required',
            'ativo' => 'bail|required'
        ];
    }
}
