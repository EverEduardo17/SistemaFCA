<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcademicoRequest extends FormRequest
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
        $academico = $this->route('academico');
        $idAcademico = $academico ? $academico->IdAcademico : null;


        // Diferenciar entre crear y actualizar
        $noPersonalAcademico = $idAcademico ? 'required|unique:Academico,NoPersonalAcademico,' . $academico->NoPersonalAcademico . ',NoPersonalAcademico' : 'required|unique:Academico,NoPersonalAcademico|max:255';
        $rfcAcademico = $idAcademico ? 'required|unique:Academico,RfcAcademico,' . $academico->RfcAcademico . ',RfcAcademico' : 'required|unique:Academico,RfcAcademico|max:255';
        $name = $idAcademico ? 'required|unique:Usuario,name,' . $academico->usuario->name . ',name' : 'required|unique:Usuario,name|max:255';
        $email = $idAcademico ? 'required|unique:Usuario,email,' . $academico->usuario->email . ',email' : 'required|unique:Usuario,email|max:255';
        // $password = $idAcademico ? 'nullable|min:8|max:255' : 'required|min:8|max:255';


        return [
            'NombreDatosPersonales'             => 'required | max:255',
            'ApellidoPaternoDatosPersonales'    => 'required | max:255',
            // 'ApellidoMaternoDatosPersonales'    => 'required | max:255',
            'NoPersonalAcademico'               => $noPersonalAcademico,
            'RfcAcademico'                      => $rfcAcademico,
            'IdRole'                            => '',
            'name'                              => $name,
            'email'                             => $email,
            // 'password'                          => $password,
        ];
    }
}
