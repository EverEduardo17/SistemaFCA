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

        // $IdEstudiante = $this->route('estudiante')->IdEstudiante; // obtenemos el ID del estudiante actual


        return [
            'NombreDatosPersonales'             => ['required', 'String', 'regex:/^[A-Za-zÁáéÉíÍóÓúÚüÜñÑ.]+(\s{1}[A-Za-záÁéÉíÍóÓúÚüÜñÑ.]+)*$/'],
            'ApellidoPaternoDatosPersonales'    => ['required', 'String', 'regex:/^[A-Za-zÁáéÉíÍóÓúÚüÜñÑ.]+(\s{1}[A-Za-záÁéÉíÍóÓúÚüÜñÑ.]+)*$/'],
            'ApellidoMaternoDatosPersonales'    => ['required', 'String', 'regex:/^[A-Za-zÁáéÉíÍóÓúÚüÜñÑ.]+(\s{1}[A-Za-záÁéÉíÍóÓúÚüÜñÑ.]+)*$/'],
            'IdCohorte'                         => 'required | numeric',
            // El formato para las matrículas está diseñado para aceptar únicamente S0.., S1.. y S2..
            'MatriculaEstudiante'               => ['required', 'String', 'max:9', 'regex:/^S[012][\d]{1}[0]{1}\d{5}$/', 'unique:Estudiante,MatriculaEstudiante,' . $IdEstudiante . ',IdEstudiante'],
            'IdProgramaEducativo'               => 'required | numeric',
            'IdGrupo'                           => 'required | numeric',
            'IdModalidad'                       => 'required | numeric',
            'Genero'                            => 'required | String',

        ];
    }
}
