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
            'TelefonoEmpresa'       => ['required', 'String', 'regex:/^((\d{3}\s{1}\d{3}\s{1}\d{4})|(\d{10}))*((\s{1}(ext|EXT|Ext)([\,\.\-\;\:])?)(\s{1}[\d\,\.\-\;]{3,5}))?$/'],
            'EmailEmpresa'          => ['required', 'String', 'regex:/^\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b$/'],
            'ResponsableEmpresa'    => ['required', 'String', 'regex:/^[A-Za-záÁéÉíÍóÓúÚüÜñÑ.]+(\s{1}[A-Za-záÁéÉíÍóÓúÚüÜñÑ.]+)*$/'],
            'TipoEmpresa'           => 'required | String',
        ];
    }
}
