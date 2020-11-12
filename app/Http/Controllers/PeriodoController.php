<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodoRequest;
use App\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PeriodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('periodo.index', [
            'periodoes' => Periodo::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('periodo.create', [
            'periodo' => new Periodo()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function show(Periodo $periodo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function edit(Periodo $periodo)
    {
        return view('periodo.edit', [
            'periodoes' => $periodo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
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
