<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportarRequest extends FormRequest
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
            'NombreCohorte'         => ['required', 'String', 'regex:/^[Ss][012][\d]{1}[0]{1}$/'],
            'NombreGrupo'           => ['required', 'String', 'regex:/^([A-Za-záÁéÉíÍóÓúÚüÜñÑ]{2,3})+(\s{1}[1-9]{1}[0][1-3]{1})$/'],
            'Documento'             => ['required', 'mimes:xlsx', 'max:2048'],
        ];
    }
}
