<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoOrganizadorRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'NombreTipoOrganizador'         =>  'required',
            'DescripcionTipoOrganizador'    => 'required'
        ];
    }
}
