<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Evento_Fecha_Sede;
use App\Models\FechaEvento;
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
            $bandera = $this->existeConflicto($evento);
            if($bandera){
                Session::flash('flash', [ ['type' => "danger", 'message' => "Una fecha tiene conflicto con un evento aprobado."] ]);
                return redirect()->route('eventos.show', $evento->IdEvento);
            }else{
                DB::beginTransaction();
                    DB::table('Evento')->where('IdEvento', $evento->IdEvento)->update([
                        'EstadoEvento'       => "APROBADO"
                    ]);
                DB::commit();
            }
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
                    'EstadoEvento'      => "NO APROBADO",
                    'Motivo'            => $validated['Motivo']
                ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Session::flash('flash', [ ['type' => "danger", 'message' => "Error al NO APROBAR del Evento."] ]);
            return redirect()->route('eventos.show', $evento->IdEvento);
        }
        Session::flash('flash', [ ['type' => "success", 'message' => "Evento NO APROBADO con éxito."] ]);
        return redirect()->route('eventos.show', $evento->IdEvento);
    }

    public function cancelar(Request $request, Evento $evento)
    {
        Gate::authorize('havepermiso', 'eventoestado-aprobar');
        $validated = $request->validate([
            'Motivo' => 'required|max:255',
        ]);
        try {
            DB::beginTransaction();
            DB::table('Evento')->where('IdEvento', $evento->IdEvento)->update([
                'EstadoEvento'      => "NO APROBADO",
                'Motivo'            => $validated['Motivo']
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Session::flash('flash', [ ['type' => "danger", 'message' => "Error al Cancelar del Evento."] ]);
            return redirect()->route('eventos.show', $evento->IdEvento);
        }
        Session::flash('flash', [ ['type' => "success", 'message' => "Evento cancelado con éxito."] ]);
        return redirect()->route('eventos.show', $evento->IdEvento);
    }

    private function existeConflicto($evento)
    {
        $fechas = Evento_Fecha_Sede::where('IdEvento', $evento->IdEvento)->get();

        foreach ($fechas as $fecha){
            if($this->conflicto($fecha->fechaEvento, $fecha)){
                return true;
            }
        }
        return false;
    }

    public function conflicto($fecha, $fechaEvento) {
        $fechas = FechaEvento::where('IdFechaEvento', '!=', $fecha->IdFechaEvento)
            ->where(function($q) use ($fecha) {
                $q->whereBetween('InicioFechaEvento', [$fecha->InicioFechaEvento, $fecha->FinFechaEvento])
                    ->orWhereBetween('FinFechaEvento', [$fecha->InicioFechaEvento, $fecha->FinFechaEvento]);
            })->get();
        foreach ($fechas as $fecha) {
            if($fecha->even->EstadoEvento == "APROBADO" && $fecha->evento_fecha_sede->IdSedeEvento == $fechaEvento->IdSedeEvento ){
                return true;
            }
        }
        return false;
    }
}
