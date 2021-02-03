<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstudianteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'NombreDatosPersonales'             => 'required | String',
            'ApellidoPaternoDatosPersonales'    => 'required | String',
            'ApellidoMaternoDatosPersonales'    => 'required | String',
            'IdCohorte'                         => 'required | numeric',
            'MatriculaEstudiante'               => 'required | String | unique:Estudiante| max:9' ,
            'IdProgramaEducativo'               => 'required | numeric',
            'IdGrupo'                           => 'required | numeric',
            'IdModalidad'                       => 'required | numeric',
            'Genero'                            => 'required | String',

        ];
    }
}
