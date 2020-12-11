<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'NombreEmpresa'       => 'required | String',
            'DireccionEmpresa'  => 'required | String',
            'LocalidadEmpresa'  => 'required | String',
            'TelefonoEmpresa'  => 'required | String',
            'ResponsableEmpresa'  => 'required | String',
            'TipoEmpresa'  => 'required | String',
            'ActividadEmpresa'  => 'required | String',
            'ClasificacionEmpresa'  => 'required | String',
        ];
    }
}
