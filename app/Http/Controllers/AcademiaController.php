<?php

namespace App\Http\Controllers;

use App\AcademicoAcademia;
use App\Http\Requests\AcademiaRequest;
use App\Academia;
use App\Academico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AcademiaController extends Controller
{
    public function index()
    {
        return view('academias.index', [
            'academias' => Academia::get()
        ]);
    }

    public function create()
    {
        return view('academias.create', [
            'academia' => new Academia,
            'coordinadores' => Academico::get()
        ]);
    }

    public function store(AcademiaRequest $request)
    {
        $request->validate([
            'NombreAcademia' => 'unique:academia,NombreAcademia'
        ]);
        try {
            Academia::create( $request->validated() );
            Session::flash('flash', [ ['type' => "success", 'message' => "Academia creada correctamente."] ]);
            return redirect()->route('academias.index');
        }catch (\Throwable $throwable){
            Session::flash('flash', [ ['type' => "danger", 'message' => "La Academia no pudo ser creada correctamente."] ]);
            return redirect()->route('academias.index');
        }

    }

    public function show(Academia $academia)
    {
        //SELECT academico.* FROM academico LEFT JOIN academico_academia on academico_academia.IdAcademico = academico.IdAcademico WHERE academico_academia.IdAcademia = 5;
        //Devuelve los que pertenecen
        //->join('academia', 'academia.IdAcademia', '=', 'aa.IdAcademia')
        $academicss = Academico::get();
        //$academicss = $academicss->academico_academia()
          //  ->where('IdAcademia', '<>', $academia->IdAcademia)->get();
//        dd($academicss);
//        $academicos = Academico::whereHas('academico_academia', function ($query) {
//                return $query->where('IdAcademia', '<>', $academia->IdAcademia);
//            })->get();
//        dd($academicos[0]);
        dd( Academico::leftjoin('academico_academia as aa', 'aa.IdAcademico', '=', 'academico.IdAcademico')->select('academico.*')->where('aa.IdAcademia', '<>', $academia->IdAcademia)->get() );
        dd( AcademicoAcademia::rightjoin('academico', 'academico.IdAcademico', '=', 'academico_academia.IdAcademico')->where('academico_academia.DeletedAt', null)->select('academico.*')->get() );
        return view('academias.show', [
            'academia'      => $academia,
            'academicos'    => $academicos,
        ]);
    }

    public function edit(Academia $academia)
    {
        return view('academias.edit', [
            'academia' => $academia,
            'coordinadores' => Academico::get()
        ]);
    }

    public function update(AcademiaRequest $request, Academia $academia)
    {
        $request->validate([
            'NombreAcademia' => 'unique:academia,NombreAcademia,'.$academia->IdAcademia.',IdAcademia'
        ]);
        try {
            $academia->update( $request->validated() );
            Session::flash('flash', [ ['type' => "success", 'message' => "Academia editada correctamente."] ]);
            return redirect()->route('academias.index');
        }catch (\Throwable $throwable){
            Session::flash('flash', [ ['type' => "danger", 'message' => "La Academia no pudo ser editada correctamente."] ]);
            return redirect()->route('academias.index');
        }
    }

    public function destroy(Academia $academia)
    {
        $academia->delete();
        return redirect()->route('academias.index');
    }

    public function destroyAcademicoAcademia(AcademicoAcademia $academicoAcademia){
        try {
            $academicoAcademia->delete();
            Session::flash('flash', [ ['type' => "success", 'message' => "El Academico fue eliminado de la Academia correctamente."] ]);
            return redirect()->route('academias.show', $academicoAcademia->IdAcademia);
        }catch (\Throwable $throwable){
            Session::flash('flash', [ ['type' => "danger", 'message' => "El Academico NO fue eliminado de la Academia correctamente."] ]);
            return redirect()->route('academias.show', $academicoAcademia->IdAcademia);
        }

    }
}
