<?php

namespace App\Http\Requests;

use App\Models\Estudiante;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EstudianteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $estudiante = $this->route('estudiante');
        $IdEstudiante = $estudiante ? $estudiante->IdEstudiante : null;

        return [
            'NombreDatosPersonales'             => ['required', 'String', 'regex:/^[A-Za-zÁáéÉíÍóÓúÚüÜñÑ.]+(\s{1}[A-Za-záÁéÉíÍóÓúÚüÜñÑ.]+)*$/'],
            'ApellidoPaternoDatosPersonales'    => ['required', 'String', 'regex:/^[A-Za-zÁáéÉíÍóÓúÚüÜñÑ.]+(\s{1}[A-Za-záÁéÉíÍóÓúÚüÜñÑ.]+)*$/'],
            'ApellidoMaternoDatosPersonales'    => ['required', 'String', 'regex:/^[A-Za-zÁáéÉíÍóÓúÚüÜñÑ.]+(\s{1}[A-Za-záÁéÉíÍóÓúÚüÜñÑ.]+)*$/'],
            // 'IdCohorte'                         => 'required | numeric',
            'MatriculaEstudiante'               => ['required', 'String', 'max:9', 'regex:/^S\d{1,8}$/i', 'unique:Estudiante,MatriculaEstudiante,' . $IdEstudiante . ',IdEstudiante'],
            // 'IdProgramaEducativo'               => 'required | numeric',
            //'IdGrupo'                           => 'numeric',
            //'IdGrupo'                           => 'required | numeric',
            // 'IdModalidad'                       => 'required | numeric',
            'Genero'                            => 'required | String',

        ];
    }
}
