<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComprovanteCreateRequest extends FormRequest
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
            'url' => 'bail|required|mimes:pdf|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'url.required' => 'É necessário escolher um arquivo',
            'url.mimes' => 'O arquivo deve ser do tipo .pdf',
            'url.max' => 'Este arquivo é muito grande, tente reduzir seu tamanho',
        ];
    }
}
