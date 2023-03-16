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
            'NombreConstancia'        => 'required | string | unique:Constancia,NombreConstancia',
            'DescripcionConstancia'   => 'required | string',
            'VigenteHasta'            => 'date_format:d/m/Y | nullable',
        ];
    }
}
