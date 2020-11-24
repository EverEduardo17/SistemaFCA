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
    public function store(Request $request)
    {
        $request->validate([
            'academico' => 'required | numeric',
        ]);

        //validar que todo existe

        $exist = AcademicoEvento::where([ ['IdAcademico', $request['academico']], ['IdEvento', $request['evento']] ] )->first();
        if ($exist){
            Session::flash('flash', [ ['type' => "danger", 'message' => "Este docente ya es participante."] ]);
            return redirect()->route('eventos.show', $request['evento']);
        }

        try {
            DB::beginTransaction();
                DB::table('academico_evento')->insert([
                    'IdAcademico'       => $request['academico'],
                    'IdEvento'          => $request['evento']
                ]);
            DB::commit();
        }catch (\Throwable $exception){
            DB::rollBack();
            Session::flash('flash', [ ['type' => "danger", 'message' => "No es posible asignar al docente."] ]);
            return redirect()->route('eventos.show', $request['evento']);
        }
        Session::flash('flash', [ ['type' => "success", 'message' => "Académico asignado correctamente."] ]);
        return redirect()->route('eventos.show', $request['evento']);
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
    public function destroy($participante) {
        $participante = AcademicoEvento::findOrFail( $participante );
        $participante->forceDelete();

        Session::flash('flash', [ ['type' => "success", 'message' => "Participante eliminado correctamente."] ]);
        return redirect()->back();
    }
}
