<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BairroCreateRequest extends FormRequest
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
            'nome' => 'bail|required|min:3|unique:bairros,nome',
            'ativo' => 'bail|required',
            'municipio_id' => 'bail|required'
        ];
    }
}
