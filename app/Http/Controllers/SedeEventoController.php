<?php

namespace App\Http\Controllers;

use App\Models\Evento_Fecha_Sede;
use App\Models\SedeEvento;
use App\Http\Requests\SedeEventoRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class SedeEventoController extends Controller
{
    public function index()
    {
        Gate::authorize('havepermiso', 'sedes-listar');
        return view('sedeEvento.index', [
            'sedes' => SedeEvento::get()
        ]);
    }

    public function create()
    {
        Gate::authorize('havepermiso', 'sedes-crear');
        return view('sedeEvento.create', [
            'sedes' => new SedeEvento()
        ]);
    }

    public function store(SedeEventoRequest $request)
    {
        Gate::authorize('havepermiso', 'sedes-crear');
        if (DB::table('SedeEvento')->where([['NombreSedeEvento', $request->NombreSedeEvento]])->doesntExist()) {
            // dd($request->validated());
            SedeEvento::create($request->validated());
            Session::flash('flash', [['type' => "success", 'message' => "Sede agregada correctamente."]]);
            return redirect()->route('sedeEventos.index');
        } else {
            Session::flash('flash', [['type' => "danger", 'message' => "La sede ya se encuentra registrada."]]);
            return redirect()->route('sedeEventos.index');
        }
    }

    public function show(SedeEvento $sedeEvento)
    {
        //
    }

    public function edit(SedeEvento $sedeEvento)
    {
        Gate::authorize('havepermiso', 'sedes-editar');
        return view('sedeEvento.edit', [
            'sede' => $sedeEvento
        ]);
    }

    public function update(SedeEventoRequest $request, SedeEvento $sedeEvento) {
        Gate::authorize('havepermiso', 'sedes-editar');
        try {
            $sedeEvento->update( $request->validated() );
            Session::flash('flash', [['type' => "success", 'message' => "Sede editada correctamente."]]);
            return redirect()->route('sedeEventos.index');
        }catch (\Throwable $throwable){
            Session::flash('flash', [['type' => "danger", 'message' => "Error al editar la sede correctamente."]]);
            return redirect()->route('sedeEventos.index');
        }

    }

    public function destroy(SedeEvento $sedeEvento) {
        Gate::authorize('havepermiso', 'sedes-eliminar');
        try {
            $sedeOcupada = Evento_Fecha_Sede::where('IdSedeEvento', $sedeEvento->IdSedeEvento)->count();
            if($sedeOcupada > 0){
                Session::flash('flash', [['type' => "danger", 'message' => "Esta Sede fue asignada a un evento, no puede ser eliminada."]]);
                return redirect()->route('sedeEventos.index');
            }
            $sedeEvento->delete();
            Session::flash('flash', [['type' => "success", 'message' => "Sede eliminada correctamente."]]);
            return redirect()->route('sedeEventos.index');
        }catch (\Throwable $throwable){
            Session::flash('flash', [['type' => "danger", 'message' => "Error al eliminar la sede correctamente."]]);
            return redirect()->route('sedeEventos.index');
        }
    }
}
