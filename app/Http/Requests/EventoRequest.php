<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventoRequest extends FormRequest
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
            'nombre' => 'required|max:100',
            'descripcion' => 'required|max:150',
            'fechaInicio' => 'required|date_format:d/m/Y',
            'horaInicio' => 'required|date_format:g:i A',
            'horaFin' => 'required|date_format:g:i A',
            'sede' => 'required|exists:App\SedeEvento,IdSedeEvento'
        ];
    }
}
