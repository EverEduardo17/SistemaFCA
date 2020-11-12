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
        return [
            'NombreDatosPersonales' => 'required',
            'ApellidoPaternoDatosPersonales' => 'required',
            'ApellidoMaternoDatosPersonales' => 'required',
            'NoPersonalAcademico' => 'required | unique:academico,NoPersonalAcademico',
            'RfcAcademico' => 'required | unique:academico,RfcAcademico',
            'name' => 'required | unique:usuario,name',
            'email' => 'required | unique:usuario,email',
            'password' => 'required'
        ];
    }
}
