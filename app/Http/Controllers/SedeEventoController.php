<?php

namespace App\Http\Controllers;

use App\SedeEvento;
use App\Http\Requests\SedeEventoRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SedeEventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sedeEvento.index', [
            'sedes' => SedeEvento::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sedeEvento.create', [
            'sedes' => new SedeEvento()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SedeEventoRequest $request)
    {
        if (DB::table('sedeevento')->where([['NombreSedeEvento', $request->NombreSedeEvento]])->doesntExist()) {
            // dd($request->validated());
            SedeEvento::create($request->validated());
            Session::flash('flash', [['type' => "success", 'message' => "Sede agregada correctamente."]]);
            return redirect()->route('sedeEventos.index');
        } else {
            Session::flash('flash', [['type' => "danger", 'message' => "La sede ya se encuentra registrada."]]);
            return redirect()->route('sedeEventos.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SedeEvento  $sedeEvento
     * @return \Illuminate\Http\Response
     */
    public function show(SedeEvento $sedeEvento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SedeEvento  $sedeEvento
     * @return \Illuminate\Http\Response
     */
    public function edit(SedeEvento $sedeEvento)
    {
        return view('sedeEvento.edit', [
            'sede' => $sedeEvento
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SedeEvento  $sedeEvento
     * @return \Illuminate\Http\Response
     */
    public function update(SedeEventoRequest $request, SedeEvento $sedeEvento)
    {
        $sedeEvento->update( $request->validated() );
        return redirect()->route('sedeEventos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SedeEvento  $sedeEvento
     * @return \Illuminate\Http\Response
     */
    public function destroy(SedeEvento $sedeEvento)
    {
        $sedeEvento->delete();
        return redirect()->route('sedeEventos.index');
    }
}
