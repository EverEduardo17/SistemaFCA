<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrupoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'NombreGrupo'           => 'required | String',
            'DescripcionGrupo'      => '',
            'IdGrupo'               => '',
            'IdProgramaEducativo'   => 'required',
            'IdCohorte'             => 'required',
            'IdPeriodoInicio'       => 'required',
            'IdPeriodoActivo'       => 'required',
            'IdFacultad'            => 'required'
        ];
    }
}
