<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrasladoRequest extends FormRequest
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
            'FacultadDestino'   => 'required',
            'CampusDestino'      => 'required',
            'IdGrupo'           => 'required',
            'IdTrayectoria'     => 'required',
            'IdPeriodo'         => 'required',
            'TipoTraslado'         => 'required',
        ];
    }
}
