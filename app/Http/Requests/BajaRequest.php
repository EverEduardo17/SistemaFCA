<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BajaRequest extends FormRequest
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
            'IdGrupo'           => 'required',
            'IdTrayectoria'     => '',
            'IdPeriodoBaja'     => 'required',
            'TipoBaja'          => 'required',
            'IdMotivo'          => 'required',
            'IdPeriodoTramite'  => 'required',
            'Matricula'         => ''
        ];
    }
}
