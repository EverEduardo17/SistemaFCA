<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConstanciaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'NombreConstancia'        => 'required | string',
            'DescripcionConstancia'   => 'required | string',
            'VigenteHasta'            => 'nullable | date_format:d/m/Y',
            'Plantilla'               => 'required | file | mimes:doc,docx'
        ];
    }
}
