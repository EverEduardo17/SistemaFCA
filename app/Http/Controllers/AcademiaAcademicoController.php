<?php

namespace App\Http\Controllers;

use App\Academia;
use App\Academico;
use App\AcademicoAcademia;
use App\Organizador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class AcademiaAcademicoController extends Controller {

    public function __construct() {
        $this->user = Auth::user();
    }

    public function index() {
        //
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        Gate::authorize('havepermiso', 'academia-academico-crear');
        $academia = Academia::findOrFail($request->academia);
        $academico = Academico::findOrFail($request->docente);

        if(AcademicoAcademia::where([['IdAcademico', $academico->IdAcademico], ['IdAcademia', $academia->IdAcademia]])->exists()){
            Session::flash('flash', [ ['type' => "danger", 'message' => "El académico ya pertenece a esta academia."] ]);
            return redirect()->route('academias.show', $academia);
        }

        try {
            DB::table('Academico_Academia')->insert([
                'IdAcademico'       => $academico->IdAcademico,
                'IdAcademia'  => $academia->IdAcademia
            ]);
        }catch (\Throwable $throwable) {
            Session::flash('flash', [ ['type' => "danger", 'message' => "El académico NO pudo ser agregado a esta academia."] ]);
            return redirect()->route('academias.show', $academia);
        }
        Session::flash('flash', [ ['type' => "success", 'message' => "El académico fue agregado a esta academia correctamente."] ]);
        return redirect()->route('academias.show', $academia);
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        Gate::authorize('havepermiso', 'academia-academico-eliminar');
        $academicoAcademia = AcademicoAcademia::findOrFail($id);
        try {
            $academicoAcademia->forceDelete();
            Session::flash('flash', [['type' => "success", 'message' => "Académico eliminado correctamente."]]);
            return redirect()->route('academicoEvento.index');
        } catch (\Throwable $throwable) {
            Session::flash('flash', [['type' => "danger", 'message' => "No es posible eliminar al Académico."]]);
            return redirect()->route('academicoEvento.index');
        }
    }
}
