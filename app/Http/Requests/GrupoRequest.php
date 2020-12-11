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
            'NombreGrupo'       => 'required | String',
            'DescripcionGrupo'  => 'required | String',
            'TotalEstudiantesGrupo'  => 'required | Integer | Min:39 | Max:51',
            'IdProgramaEducativo'  => 'required',
            'IdCohorte'  => 'required',
            'IdPeriodoInicio'  => 'required',
            'IdPeriodoActivo'  => 'required'
        ];
    }
}
