<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicioSocialEstudianteRequest extends FormRequest
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
            'NombreEmpresa' => ['required', 'String', 'regex:/^[A-Za-zÁéÉíÍóÓúÚüÜñÑ\d:,;.]+(\s{1}[-A-Za-záÁéÉíÍóÓúÚüÜñÑ\d:;,.-]+)*$/'],
            'IdTrayectoria' => 'required'
        ];
    }
}
