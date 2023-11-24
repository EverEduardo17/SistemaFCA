<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'evento'                => 'required',
            'NombreDocumento'       => 'required | String',
            'DescripcionDocumento'  => 'required | String',
            'FormatoDocumento'      => 'required | mimes:rar,zip,7z,pdf,jpeg,jpg,png,svg|max:2048',
        ];
    }
}
