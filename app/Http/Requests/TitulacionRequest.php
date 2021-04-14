<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TitulacionRequest extends FormRequest
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
            'PromedioEgreso'        => ['required', 'numeric', 'regex:/^(10|([1-9]{1})+(\.\d{1,2})?)$/'],
            'FechaInicioTramite'    => 'required | date',
            'FechaFinTramite'       => 'required | date',
            'EstadoTitulacion'      => 'required',
            'MencionHonorifica'     => 'required',
            'ResultadoTitulacion'   => '',
            'IdModalidad'           => 'required',
            'IdGrupo'               => 'required',
            'IdPeriodoEgreso'       => 'required',
            'IdTrayectoria'         => 'required',
        ];
    }
}
