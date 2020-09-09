<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;

class FechaEventoRequest extends FormRequest
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
            'fechaInicio' => 'required|date_format:d/m/Y',
            'horaInicio' => 'required|date_format:g:i A',
            'horaFin' => 'required|date_format:g:i A',
            'evento' => 'required|exists:App\Evento,IdEvento',
            'fechaEvento' => 'required|exists:App\FechaEvento,IdFechaEvento',
            'sede' => 'required|exists:App\SedeEvento,IdSedeEvento'
        ];
    }
    public function withValidator($validator)
    {
        if ($validator->fails()) {
            Session::flash('flash', [ ['type' => "danger", 'message' => "No fue posible añadir la fecha."] ]);
        }
    }
}
