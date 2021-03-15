<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;

class FechaEventoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fechaInicio' => 'required|date_format:d/m/Y',
            'horaInicio' => 'required|date_format:g:i A',
            'horaFin' => 'required|date_format:g:i A',
            'evento' => 'required|exists:App\Models\Evento,IdEvento',
            'fechaEvento' => 'required|exists:App\Models\FechaEvento,IdFechaEvento',
            'sede' => 'required|exists:App\Models\SedeEvento,IdSedeEvento'
        ];
    }
    public function withValidator($validator)
    {
        if ($validator->fails()) {
            Session::flash('flash', [ ['type' => "danger", 'message' => "No fue posible añadir la fecha."] ]);
        }
    }
}
