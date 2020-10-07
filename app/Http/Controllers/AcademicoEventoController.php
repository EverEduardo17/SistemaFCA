<?php

namespace App\Http\Controllers;

use App\Academico;
use App\AcademicoEvento;
use App\Evento;
use Illuminate\Http\Request;
use App\Http\Requests\AcademicoEventoRequest;

class AcademicoEventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('academicoEvento.index', [
            'academicoEvento' => AcademicoEvento::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('academicoEvento.create', [
            'eventos' => Evento::get(),
            'academicoes' => Academico::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AcademicoEventoRequest $request)
    {
        AcademicoEvento::create( $request->validated() );
        return redirect()->route('academicoEvento.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Academico  $academico
     * @return \Illuminate\Http\Response
     */
    public function show(Academico $academico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Academico  $academico
     * @return \Illuminate\Http\Response
     */
    public function edit(Academico $academico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Academico  $academico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Academico $academico)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Academico  $academico
     * @return \Illuminate\Http\Response
     */
    public function destroy(Academico $academico)
    {
        //
    }
}
