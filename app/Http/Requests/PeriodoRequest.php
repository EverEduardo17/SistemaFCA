<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeriodoRequest extends FormRequest
{ 
    public function authorize()
    {
        return true;
    }
 
    public function rules()
    {
        return [
            'NombrePeriodo' => 'required',
            'FechaInicioPeriodo' => 'date_format:YYYY-MM-DD'
        ];
    }
}
