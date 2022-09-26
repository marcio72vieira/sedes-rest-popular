<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompraCreateRequest extends FormRequest
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
            'data_fin'          =>'bail|required',
            'semana'            =>'bail|required',
            'valor'             =>'bail|required',
            'valoraf'           =>'bail|required',
            //'valortotal'        =>'bail|required',    // é calculado automaticamente
            //'restaurante_id'    =>'bail|required',
        ];
    }
}
