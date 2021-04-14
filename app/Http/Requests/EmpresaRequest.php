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
            'NombreEmpresa'         => ['required', 'String', 'regex:/^[A-Za-záÁéÉíÍóÓúÚüÜñÑ\d:,;.]+(\s{1}[-A-Za-záÁéÉíÍóÓúÚüÜñÑ\d:;,.-]+)*$/'],
            'DireccionEmpresa'      => ['required', 'String', 'regex:/^[A-Za-záÁéÉíÍóÓúÚüÜñÑ\d:,;.]+(\s{1}[-A-Za-záÁéÉíÍóÓúÚüÜñÑ\d:;,.-]+)*$/'],
            'LocalidadEmpresa'      => ['required', 'String', 'regex:/^[A-Za-záÁéÉíÍóÓúÚüÜñÑ\d:,;.]+(\s{1}[A-Za-záÁéÉíÍóÓúÚüÜñÑ\d:;,.]+)*$/'],
            'TelefonoEmpresa'       => ['required', 'String', 'regex:/^(\d{10})+(\s{1}[-A-Za-záÁéÉíÍóÓúÚüÜñÑ\d:;,.-]+)*$/'],
            'ResponsableEmpresa'    => ['required', 'String', 'regex:/^[A-Za-záÁéÉíÍóÓúÚüÜñÑ.]+(\s{1}[A-Za-záÁéÉíÍóÓúÚüÜñÑ.]+)*$/'],
            'TipoEmpresa'           => 'required | String',
            'ActividadEmpresa'      => 'required | String',
            'ClasificacionEmpresa'  => 'required | String',
        ];
    }
}
