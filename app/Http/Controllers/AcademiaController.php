<?php

namespace App\Http\Controllers;

use App\Models\AcademicoAcademia;
use App\Http\Requests\AcademiaRequest;
use App\Models\Academia;
use App\Models\Academico;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class AcademiaController extends Controller
{
    public function index() {
        Gate::authorize('havepermiso', 'academias-listar');
        return view('academias.index', [
            'academias' => Academia::with('coordinador')->get()
        ]);
    }

    public function create() {
        Gate::authorize('havepermiso', 'academias-crear');
        return view('academias.create', [
            'academia' => new Academia,
            'coordinadores' => Academico::with('usuario')->get()
        ]);
    }

    public function store(AcademiaRequest $request) {
        Gate::authorize('havepermiso', 'academias-crear');
        $request->validate([
            'NombreAcademia' => 'unique:Academia,NombreAcademia'
        ]);
        try {
            DB::beginTransaction();
                $academiaId = DB::table('Academia')->insertGetId([
                    'NombreAcademia'        => $request['NombreAcademia'],
                    'DescripcionAcademia'   => $request['DescripcionAcademia'],
                    'Coordinador'           => $request['Coordinador']
                ]);
                DB::table('Academico_Academia')->insert([
                    'IdAcademico'       => $request['Coordinador'],
                    'IdAcademia'        => $academiaId
                ]);
            DB::commit();

            Session::flash('flash', [ ['type' => "success", 'message' => "Academia creada correctamente."] ]);
            return redirect()->route('academias.index');
        }catch (\Throwable $throwable){
            DB::rollBack();
            Session::flash('flash', [ ['type' => "danger", 'message' => "La Academia NO pudo ser creada correctamente."] ]);
            return redirect()->route('academias.index');
        }
    }

    public function show($idAcademia) {
        Gate::authorize('havepermiso', 'academias-leer');

        $academia = Academia::with('academico_academia', 'coordinador')->findOrFail($idAcademia);

        $data = AcademicoAcademia::select('IdAcademico')->where('IdAcademia', $academia->IdAcademia)->get()->toArray();
        $academicosNot = Academico::whereNotIn('IdAcademico', $data)->with('usuario')->get();

        return view('academias.show', [
            'academia'      => $academia,
            'academicos'    => $academicosNot,
        ]);
    }

    public function edit(Academia $academia) {
        Gate::authorize('havepermiso', 'academias-editar');
        return view('academias.edit', [
            'academia' => $academia,
            'coordinadores' => Academico::with('usuario')->get()
        ]);
    }

    public function update(AcademiaRequest $request, Academia $academia) {
        Gate::authorize('havepermiso', 'academias-editar');
        $request->validate([
            'NombreAcademia' => 'unique:Academia,NombreAcademia,'.$academia->IdAcademia.',IdAcademia'
        ]);
        try {
            $academia->update( $request->validated() );
            Session::flash('flash', [ ['type' => "success", 'message' => "Academia actualizada correctamente."] ]);
            return redirect()->route('academias.index');
        }catch (\Throwable $throwable){
            Session::flash('flash', [ ['type' => "danger", 'message' => "La Academia NO puede ser actualizada correctamente."] ]);
            return redirect()->route('academias.index');
        }
    }

    public function destroy(Academia $academia) {
        Gate::authorize('havepermiso', 'academias-eliminar');
        try {
            $academia->delete();
            Session::flash('flash', [ ['type' => "success", 'message' => "Academia eliminada correctamente."] ]);
            return redirect()->route('academias.index');
        }catch (\Throwable $throwable){
            Session::flash('flash', [ ['type' => "danger", 'message' => "La Academia NO pudo ser eliminada correctamente."] ]);
            return redirect()->route('academias.index');
        }

    }

    public function destroyAcademicoAcademia(AcademicoAcademia $academicoAcademia){
        try {
            $academicoAcademia->forceDelete();
            Session::flash('flash', [ ['type' => "success", 'message' => "El Académico fue eliminado de la academia correctamente."] ]);
            return redirect()->route('academias.show', $academicoAcademia->IdAcademia);
        }catch (\Throwable $throwable){
            Session::flash('flash', [ ['type' => "danger", 'message' => "El Académico NO fue eliminado de la Academia correctamente."] ]);
            return redirect()->route('academias.show', $academicoAcademia->IdAcademia);
        }

    }
}
