<?php

namespace App\Http\Controllers;

use App\Organizador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class OrganizadorController extends Controller {
    public function index() {
        //
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        Gate::authorize('havepermiso', 'responsable-eliminar');
        $request->validate([
            'academico' => 'required | numeric',
            'organizador' => 'required | numeric'
        ]);

        //validar que todo existe

        $exist = Organizador::where([ ['IdAcademico', $request['academico']], ['IdEvento', $request['evento']],
            ['IdTipoOrganizador', $request['organizador']] ])->first();
        if ($exist){
            Session::flash('flash', [ ['type' => "danger", 'message' => "Este docente ya es este organizador."] ]);
            return redirect()->route('eventos.show', $request['evento']);
        }

        try {
            DB::beginTransaction();
                DB::table('Organizador')->insert([
                    'IdAcademico'       => $request['academico'],
                    'IdEvento'          => $request['evento'],
                    'IdTipoOrganizador' => $request['organizador']
                ]);
            DB::commit();
        }catch (\Throwable $exception){
            DB::rollBack();
            Session::flash('flash', [ ['type' => "danger", 'message' => "La asignacion no pudo ser registrado."] ]);
            return redirect()->route('eventos.show', $request['evento']);
        }
        Session::flash('flash', [ ['type' => "success", 'message' => "Academico asignador correctamente."] ]);
        return redirect()->route('eventos.show', $request['evento']);
    }

    public function show(Organizador $organizador) {
        //
    }

    public function edit(Organizador $organizador) {
        //
    }
    public function update(Request $request, $organizador) {
        //
    }
    public function destroy($organizador){
        Gate::authorize('havepermiso', 'responsable-eliminar');
        $organizador = Organizador::findOrFail( $organizador );
        $organizador->forceDelete();

        Session::flash('flash', [ ['type' => "success", 'message' => "Organizador Eliminado Correctamente."] ]);
        return redirect()->back();
    }
}
