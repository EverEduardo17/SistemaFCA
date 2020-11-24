<?php

namespace App\Http\Controllers;

use App\AcademicoAcademia;
use App\Http\Requests\AcademiaRequest;
use App\Academia;
use App\Academico;
use Illuminate\Support\Facades\Session;

class AcademiaController extends Controller
{
    public function index() {
        return view('academias.index', [
            'academias' => Academia::get()
        ]);
    }

    public function create() {
        return view('academias.create', [
            'academia' => new Academia,
            'coordinadores' => Academico::get()
        ]);
    }

    public function store(AcademiaRequest $request) {
        $request->validate([
            'NombreAcademia' => 'unique:Academia,NombreAcademia'
        ]);
        try {
            Academia::create( $request->validated() );
            Session::flash('flash', [ ['type' => "success", 'message' => "Academia creada correctamente."] ]);
            return redirect()->route('academias.index');
        }catch (\Throwable $throwable){
            Session::flash('flash', [ ['type' => "danger", 'message' => "La Academia NO pudo ser creada correctamente."] ]);
            return redirect()->route('academias.index');
        }
    }

    public function show(Academia $academia) {
        $data = AcademicoAcademia::select('IdAcademico')->where('IdAcademia', $academia->IdAcademia)->get()->toArray();
        $academicosNot = Academico::whereNotIn('IdAcademico', $data)->get();

        return view('academias.show', [
            'academia'      => $academia,
            'academicos'    => $academicosNot,
        ]);
    }

    public function edit(Academia $academia) {
        return view('academias.edit', [
            'academia' => $academia,
            'coordinadores' => Academico::get()
        ]);
    }

    public function update(AcademiaRequest $request, Academia $academia) {
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
