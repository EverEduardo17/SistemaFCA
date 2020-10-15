<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacultadRequest;
use App\Facultad;
use App\AcademicoEvento;
use Illuminate\Http\Request;

class FacultadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = AcademicoEvento::get();
        dd($item[0]->evento->NombreEvento);
        return view('facultades.index', [
            'facultades' => Facultad::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('facultades.create', [
            'facultad' => new Facultad()
        ]);
    }

    public function store(FacultadRequest $request)
    {
        $request->validate([
            'NombreFacultad' => 'unique:facultad,NombreFacultad',
            'ClaveFacultad' => 'unique:facultad,ClaveFacultad'
        ]);
        Facultad::create($request->validated());
        return redirect()->route('facultades.index');
    }

    public function show(Facultad $facultad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facultad $facultade)
    {
        return view('facultades.edit', [
            'facultad' => $facultade
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FacultadRequest $request, Facultad $facultade)
    {
        $request->validate([
            'NombreFacultad' => 'unique:facultad,NombreFacultad,'.$facultade->IdFacultad.',IdFacultad',
            'ClaveFacultad' => 'unique:facultad,ClaveFacultad,'.$facultade->IdFacultad.',IdFacultad'
        ]);
        $facultade->update( $request->validated() );
        return redirect()->route('facultades.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facultad $facultade)
    {
        $facultade->delete();
        return redirect()->route('facultades.index');
    }
}
