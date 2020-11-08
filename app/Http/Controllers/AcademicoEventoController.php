<?php

namespace App\Http\Controllers;

use App\Academico;
use App\AcademicoEvento;
use App\Evento;
use Illuminate\Http\Request;
use App\Http\Requests\AcademicoEventoRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
            'eventoes' => Evento::get(),
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
        if (DB::table('academico_evento')->where([['IdEvento', $request->IdEvento], ['IdAcademico', $request->IdAcademico]])->doesntExist()) {
            AcademicoEvento::create($request->validated());
            Session::flash('flash', [['type' => "success", 'message' => "Académico agregado correctamente."]]);
            return redirect()->route('academicoEvento.index');
        } else {
            // dd($request);
            // !!Checar bien esta parte del método, falta actualizar.
            // if (DB::table('academico_evento')->where([['IdEvento', $request->IdEvento], ['IdAcademico', $request->IdAcademico]])->exists()) {
            //     $request->DeletedAt = null;
            //     AcademicoEvento::updated($request->validated());
            //     Session::flash('flash', [['type' => "success", 'message' => "Académico agregado correctamente."]]);
            //     return redirect()->route('academicoEvento.index');
            // }
            Session::flash('flash', [['type' => "danger", 'message' => "El académico ya está registrado en ese evento."]]);
            return redirect()->route('academicoEvento.index');
        }
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
    public function destroy(AcademicoEvento $academicoEvento)
    {
        try {
            $academicoEvento->forceDelete();
            Session::flash('flash', [['type' => "success", 'message' => "Académico eliminado correctamente."]]);
            return redirect()->route('academicoEvento.index');
        } catch (\Throwable $throwable) {
            Session::flash('flash', [['type' => "danger", 'message' => "No es posible eliminar al Académico."]]);
            return redirect()->route('academicoEvento.index');
        }
    }
}
