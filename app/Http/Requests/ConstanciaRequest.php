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
            'NombreConstancia'        => 'required | String',
            'DescripcionConstancia'   => 'required | String',
            'VigenteHasta'            => 'date_format:d/m/Y',
        ];
    }
}
