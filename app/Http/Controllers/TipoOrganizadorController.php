<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoOrganizadorRequest;
use App\Models\Organizador;
use App\Models\TipoOrganizador;
use App\Models\TipoOrganizadoro;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class TipoOrganizadorController extends Controller {

    public function index() {
        Gate::authorize('havepermiso', 'tipoorganizador-listar');
        return view('tipoorganizador.index', [
            'tipoorganizadores' => TipoOrganizador::get()
        ]);
    }

    public function create() {
        Gate::authorize('havepermiso', 'tipoorganizador-crear');
        return view('tipoorganizador.create');
    }

    public function store(TipoOrganizadorRequest $request) {
        Gate::authorize('havepermiso', 'tipoorganizador-crear');
        $request = $request->validated();

        try {
            DB::beginTransaction();
                DB::table('TipoOrganizador')->insert([
                    'NombreTipoOrganizador'      => $request['NombreTipoOrganizador'],
                    'DescripcionTipoOrganizador' => $request['DescripcionTipoOrganizador']
                ]);
            DB::commit();
        }catch (\Throwable $exception){
            DB::rollBack();
            Session::flash('flash', [ ['type' => "danger", 'message' => "El Tipo de Organizador NO pudo ser registrado."] ]);
            return redirect()->route('tipoorganizador.index');
        }
        Session::flash('flash', [ ['type' => "success", 'message' => "El Tipo de Organizador fue registrado con éxito."] ]);
        return redirect()->route('tipoorganizador.index');
    }

    public function show(TipoOrganizador $tipoOrganizador) {
        //
    }

    public function edit(TipoOrganizador $tipoOrganizador) {
        //
    }

    public function update(TipoOrganizadorRequest $request, $tipoOrganizador) {
        Gate::authorize('havepermiso', 'tipoorganizador-editar');
        $request = $request->validated();

        try {
            DB::beginTransaction();
                DB::table('TipoOrganizador')->where('IdTipoOrganizador', $tipoOrganizador)->update([
                   'NombreTipoOrganizador'      => $request['NombreTipoOrganizador'],
                   'DescripcionTipoOrganizador' => $request['DescripcionTipoOrganizador']
                ]);
            DB::commit();
        }catch (\Throwable $exception){
            DB::rollBack();
            Session::flash('flash', [ ['type' => "danger", 'message' => "El Tipo de Organizador NO pudo ser actualizado."] ]);
            return redirect()->route('tipoorganizador.index');
        }
        Session::flash('flash', [ ['type' => "success", 'message' => "Tipo de Organizador actualizado con éxito."] ]);
        return redirect()->route('tipoorganizador.index');
    }

    public function destroy($tipoOrganizador) {
        Gate::authorize('havepermiso', 'tipoorganizador-eliminar');
        try {
            $tipoOrganizador = TipoOrganizador::findOrFail($tipoOrganizador);
            $tipoOcupado = Organizador::where('IdTipoOrganizador', $tipoOrganizador->IdTipoOrganizador)->count();
            if($tipoOcupado > 0){
                Session::flash('flash', [['type' => "danger", 'message' => "Este Tipo de Organizador fue asignado a un evento, no puede ser eliminado."]]);
                return redirect()->route('tipoorganizador.index');
            }
            $tipoOrganizador->delete();
            Session::flash('flash', [['type' => "success", 'message' => "Tipo de Organizador eliminado con éxito."]]);
            return redirect()->route('tipoorganizador.index');
        }catch (\Throwable $throwable){
            Session::flash('flash', [['type' => "danger", 'message' => "Error al eliminar el Tipo de Organizador."]]);
            return redirect()->route('tipoorganizador.index');
        }
    }
}
