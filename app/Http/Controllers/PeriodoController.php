<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodoRequest;
use App\Models\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PeriodoController extends Controller
{
    public function index()
    {
        return view('periodo.index', [
            'periodoes' => Periodo::get()
        ]);
    }

    public function create()
    {
        return view('periodo.create', [
            'periodo' => new Periodo()
        ]);
    }

    public function store(PeriodoRequest $request)
    {
        //!! Falta corregir el formato de las fechas.
        // dd($request);
        $request->validate([
            'NombrePeriodo' => 'unique:Periodo,NombrePeriodo'
        ]);
        try {
            Periodo::create( $request->validated() );
            Session::flash('flash', [ ['type' => "success", 'message' => "Periodo creado correctamente."] ]);
            return redirect()->route('periodo.index');
        }catch (\Throwable $throwable){
            dd($throwable);
            Session::flash('flash', [ ['type' => "danger", 'message' => "El periodo no pudo ser creado correctamente."] ]);
            return redirect()->route('periodo.index');
        }
    }

    public function show(Periodo $periodo)
    {
        //
    }

    public function edit(Periodo $periodo)
    {
        return view('periodo.edit', [
            'periodoes' => $periodo
        ]);
    }

    public function update(PeriodoRequest $request, Periodo $periodo)
    {
        $request->validate([
            'NombrePeriodo' => 'unique:Periodo,NombrePeriodo,'.$periodo->IdPerido.',IdPeriodo'
        ]);
        try {
            $periodo->update( $request->validated() );
            Session::flash('flash', [ ['type' => "success", 'message' => "Academia editada correctamente."] ]);
            return redirect()->route('periodo.index');
        }catch (\Throwable $throwable){
            Session::flash('flash', [ ['type' => "danger", 'message' => "La Academia no pudo ser editada correctamente."] ]);
            return redirect()->route('periodo.index');
        }
    }

    public function destroy(Periodo $periodo)
    {
        try {
            $periodo->forceDelete();
            Session::flash('flash', [ ['type' => "success", 'message' => "Periodo eliminado correctamente."] ]);
            return redirect()->route('periodo.index');
        }catch (\Throwable $throwable){
            Session::flash('flash', [ ['type' => "danger", 'message' => "El periodo no pudo ser eliminada correctamente."] ]);
            return redirect()->route('periodo.index');
        }
    }
}
