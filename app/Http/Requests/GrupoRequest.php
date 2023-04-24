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
            'NombreGrupo'           => ['required', 'String', 'unique:Grupo'],  //regex:/^([A-Za-z]{2,3})+(\s{1}[1-9]{1}[0][1-3]{1})$/
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
