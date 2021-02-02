<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class EventoEstadoController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request, Evento $evento)
    {
        Gate::authorize('havepermiso', 'eventoestado-aprobar');
        try {
            DB::beginTransaction();
                DB::table('Evento')->where('IdEvento', $evento->IdEvento)->update([
                    'EstadoEvento'       => "APROBADO"
                ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Session::flash('flash', [ ['type' => "danger", 'message' => "Error al aprobar el Evento."] ]);
            return redirect()->route('eventos.show', $evento->IdEvento);
        }
        Session::flash('flash', [ ['type' => "success", 'message' => "Evento aprobado con éxito."] ]);
        return redirect()->route('eventos.show', $evento->IdEvento);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $evento)
    {
        Gate::authorize('havepermiso', 'eventoestado-editar');
        $evento = Evento::findOrFail($evento);
        try {
            DB::beginTransaction();
            DB::table('Evento')->where('IdEvento', $evento->IdEvento)->update([
                'EstadoEvento'       => "POR APROBAR"
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Session::flash('flash', [ ['type' => "danger", 'message' => "Error al solicitar la aprobacion del Evento."] ]);
            return redirect()->route('eventos.show', $evento->IdEvento);
        }
        Session::flash('flash', [ ['type' => "success", 'message' => "Solicitud del evento con éxito."] ]);
        return redirect()->route('eventos.show', $evento->IdEvento);
    }

    public function destroy($id)
    {
        //
    }

    public function rechazo(Request $request, Evento $evento)
    {
        Gate::authorize('havepermiso', 'eventoestado-aprobar');
        $validated = $request->validate([
            'Motivo' => 'required|max:255',
        ]);
        try {
            DB::beginTransaction();
                DB::table('Evento')->where('IdEvento', $evento->IdEvento)->update([
                    'EstadoEvento'      => "RECHAZADO",
                    'Motivo'            => $validated['Motivo']
                ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Session::flash('flash', [ ['type' => "danger", 'message' => "Error al rechazar del Evento."] ]);
            return redirect()->route('eventos.show', $evento->IdEvento);
        }
        Session::flash('flash', [ ['type' => "success", 'message' => "Evento rechazado con éxito."] ]);
        return redirect()->route('eventos.show', $evento->IdEvento);
    }
}
