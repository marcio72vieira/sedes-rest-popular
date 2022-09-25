<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompraUpdateRequest extends FormRequest
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
            'data_ini'          =>'bail|required',
            'data_fim'          =>'bail|required',
            'semana'            =>'bail|required',
            'valorsemaf'        =>'bail|required',
            'valorcomaf'        =>'bail|required',
            'valortotal'        =>'bail|required',
            'restaurante_id'    =>'bail|required',
        ];
    }
}
