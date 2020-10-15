<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoOrganizadorRequest;
use App\TipoOrganizador;
use Illuminate\Http\Request;
use App\TipoOrganizadoro;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;
use Yaf\Exception;

class TipoOrganizadorController extends Controller {

    public function index() {
        return view('tipoorganizador.index', [
            'tipoorganizadores' => TipoOrganizador::get()
        ]);
    }

    public function create() {
        return view('tipoorganizador.create');
    }

    public function store(TipoOrganizadorRequest $request) {
        $request = $request->validated();

        try {
            DB::beginTransaction();
                DB::table('tipoorganizador')->insert([
                    'NombreTipoOrganizador'      => $request['NombreTipoOrganizador'],
                    'DescripcionTipoOrganizador' => $request['DescripcionTipoOrganizador']
                ]);
            DB::commit();
        }catch (\Throwable $exception){
            DB::rollBack();
            Session::flash('flash', [ ['type' => "danger", 'message' => "Tipo de Organizador no pudo ser registrado."] ]);
            return redirect()->route('tipoorganizador.index');
        }
        Session::flash('flash', [ ['type' => "success", 'message' => "Tipo Organizador fue Registrado Con Exito."] ]);
        return redirect()->route('tipoorganizador.index');
    }

    public function show(TipoOrganizador $tipoOrganizador) {
        //
    }

    public function edit(TipoOrganizador $tipoOrganizador) {
        //
    }

    public function update(TipoOrganizadorRequest $request, $tipoOrganizador) {
        $request = $request->validated();

        try {
            DB::beginTransaction();
                DB::table('tipoorganizador')->where('IdTipoOrganizador', $tipoOrganizador)->update([
                   'NombreTipoOrganizador'      => $request['NombreTipoOrganizador'],
                   'DescripcionTipoOrganizador' => $request['DescripcionTipoOrganizador']
                ]);
            DB::commit();
        }catch (\Throwable $exception){
            DB::rollBack();
            Session::flash('flash', [ ['type' => "danger", 'message' => "Tipo de Organizador no pudo ser actualizado."] ]);
            return redirect()->route('tipoorganizador.index');
        }
        Session::flash('flash', [ ['type' => "success", 'message' => "Tipo Organizador Actualizado Con Exito."] ]);
        return redirect()->route('tipoorganizador.index');
    }

    public function destroy(TipoOrganizador $tipoOrganizador) {
        //
    }
}
