<?php

namespace App\Http\Controllers;

use App\Models\Academico;
use App\Models\AcademicoEvento;
use App\Models\Evento;
use Illuminate\Http\Request;
use App\Http\Requests\AcademicoEventoRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class AcademicoEventoController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        Gate::authorize('havepermiso', 'participantes-crear');
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
                DB::table('Academico_Evento')->insert([
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

    public function show(Academico $academico)
    {
        //
    }

    public function edit(Academico $academico)
    {
        //
    }

    public function update(Request $request, Academico $academico)
    {
        //
    }

    public function destroy($participante) {
        Gate::authorize('havepermiso', 'participantes-eliminar');
        $participante = AcademicoEvento::findOrFail( $participante );
        $participante->forceDelete();

        Session::flash('flash', [ ['type' => "success", 'message' => "Participante eliminado correctamente."] ]);
        return redirect()->back();
    }
}
