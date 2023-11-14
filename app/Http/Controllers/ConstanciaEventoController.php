<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ConstanciaEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class ConstanciaEventoController extends Controller
{
    public function store(Request $request) {
        Gate::authorize('havepermiso', 'documentos-crear');

        $request->validate([
            'constancia' => 'required',
            'evento' => 'required',
        ]);

        try {
            $constanciaEvento = new ConstanciaEvento([
                'IdConstancia' => $request->constancia,
                'IdEvento' => $request->evento
            ]);
            $constanciaEvento->save();
            Session::flash('flash', [['type' => "success", 'message' => "Constancia asignada al evento correctamente"]]);
            return redirect()->route('eventos.show', $request->evento);
        } catch (\Throwable $th) {
            Session::flash('flash', [['type' => "danger", 'message' => "Error al asignar constancia al evento."]]);
            return redirect()->route('eventos.show', $request->evento);
        }
    }

    public function destroy(Request $request) {
        Gate::authorize('havepermiso', 'documentos-crear');

        $request->validate([
            'evento' => 'required',
            'constancia' => 'required',
        ]);

        $IdEvento = $request->evento;
        $IdConstancia = $request->constancia;

        try {
            $constanciaEvento = ConstanciaEvento::findOrFail($IdConstancia);
            $constanciaEvento->delete();
            Session::flash('flash', [['type' => "success", 'message' => "Constancia eliminada del evento correctamente"]]);
            return redirect()->route('eventos.show', $IdEvento);
        } catch (\Throwable $th) {
            Session::flash('flash', [['type' => "danger", 'message' => "Error al eliminar constancia del evento."]]);
            return redirect()->route('eventos.show', $IdEvento);
        }
    }
}
