<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditarEventoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'NombreEvento'       => 'required | String',
            'DescripcionEvento'  => 'required | String',
        ];
    }
}
