<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacultadRequest;
use App\Models\Facultad;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;


class FacultadController extends Controller
{
    public function index()
    {
        Gate::authorize('havepermiso', 'facultades-listar');
        return view('facultades.index', [
            'facultades' => Facultad::get()
        ]);
    }

    public function create()
    {
        Gate::authorize('havepermiso', 'facultades-crear');
        return view('facultades.create', [
            'facultad' => new Facultad()
        ]);
    }

    public function store(FacultadRequest $request)
    {
        Gate::authorize('havepermiso', 'facultades-crear');
        $request->validate([
            'NombreFacultad' => 'unique:Facultad,NombreFacultad',
            'ClaveFacultad' => 'unique:Facultad,ClaveFacultad'
        ]);
        try {
            Facultad::create($request->validated());
            Session::flash('flash', [['type' => "success", 'message' => "Facultad creada correctamente."]]);
            return redirect()->route('facultades.index');
        } catch (\Throwable $throwable) {
            Session::flash('flash', [['type' => "danger", 'message' => "la Facultad No pudo ser creada correctamente."]]);
            return redirect()->route('facultades.index');
        }
    }

    public function show(Facultad $facultad)
    {
        //
    }

    public function edit(Facultad $facultade)
    {
        Gate::authorize('havepermiso', 'facultades-editar');
        return view('facultades.edit', [
            'facultad' => $facultade
        ]);
    }

    public function update(FacultadRequest $request, Facultad $facultade)
    {
        Gate::authorize('havepermiso', 'facultades-editar');
        $request->validate([
            'NombreFacultad' => 'unique:Facultad,NombreFacultad,' . $facultade->IdFacultad . ',IdFacultad',
            'ClaveFacultad' => 'unique:Facultad,ClaveFacultad,' . $facultade->IdFacultad . ',IdFacultad'
        ]);
        try {
            $facultade->update($request->validated());
            Session::flash('flash', [['type' => "success", 'message' => "Facultad editada correctamente."]]);
            return redirect()->route('facultades.index');
        } catch (\Throwable $throwable) {
            Session::flash('flash', [['type' => "danger", 'message' => "la Facultad No pudo ser editada correctamente."]]);
            return redirect()->route('facultades.index');
        }
    }

    public function destroy(Facultad $facultade)
    {
        Gate::authorize('havepermiso', 'facultades-eliminar');
        try {
            $facultade->forceDelete();
            Session::flash('flash', [['type' => "success", 'message' => "Facultad eliminada correctamente."]]);
            return redirect()->route('facultades.index');
        } catch (\Throwable $throwable) {
            Session::flash('flash', [['type' => "danger", 'message' => "la Facultad No pudo ser eliminada correctamente."]]);
            return redirect()->route('facultades.index');
        }
    }
}
