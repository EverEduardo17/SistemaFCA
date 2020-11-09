<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacultadRequest;
use App\Facultad;
use App\AcademicoEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

<<<<<<< HEAD
class FacultadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = AcademicoEvento::get();
=======
class FacultadController extends Controller{

    public function index(){
>>>>>>> a625e6847c17c04f27d8d60df1a1db91e4e6420a
        return view('facultades.index', [
            'facultades' => Facultad::get()
        ]);
    }

    public function create(){
        return view('facultades.create', [
            'facultad' => new Facultad()
        ]);
    }

    public function store(FacultadRequest $request){
        $request->validate([
            'NombreFacultad' => 'unique:facultad,NombreFacultad',
            'ClaveFacultad' => 'unique:facultad,ClaveFacultad'
        ]);
        try {
            Facultad::create($request->validated());
            Session::flash('flash', [ ['type' => "success", 'message' => "Facultad creada correctamente."] ]);
            return redirect()->route('facultades.index');
        }catch (\Throwable $throwable){
            Session::flash('flash', [ ['type' => "danger", 'message' => "la Facultad No pudo ser creada correctamente."] ]);
            return redirect()->route('facultades.index');
        }

    }

    public function show(Facultad $facultad) {
        //
    }

    public function edit(Facultad $facultade) {
        return view('facultades.edit', [
            'facultad' => $facultade
        ]);
    }

    public function update(FacultadRequest $request, Facultad $facultade) {
        $request->validate([
            'NombreFacultad' => 'unique:facultad,NombreFacultad,'.$facultade->IdFacultad.',IdFacultad',
            'ClaveFacultad' => 'unique:facultad,ClaveFacultad,'.$facultade->IdFacultad.',IdFacultad'
        ]);
        try {
            $facultade->update( $request->validated() );
            Session::flash('flash', [ ['type' => "success", 'message' => "Facultad editada correctamente."] ]);
            return redirect()->route('facultades.index');
        }catch (\Throwable $throwable){
            Session::flash('flash', [ ['type' => "danger", 'message' => "la Facultad No pudo ser editada correctamente."] ]);
            return redirect()->route('facultades.index');
        }
    }

    public function destroy(Facultad $facultade) {
        try {
            $facultade->delete();
            Session::flash('flash', [ ['type' => "success", 'message' => "Facultad eliminada correctamente."] ]);
            return redirect()->route('facultades.index');
        }catch (\Throwable $throwable){
            Session::flash('flash', [ ['type' => "danger", 'message' => "la Facultad No pudo ser eliminada correctamente."] ]);
            return redirect()->route('facultades.index');
        }
    }
}
