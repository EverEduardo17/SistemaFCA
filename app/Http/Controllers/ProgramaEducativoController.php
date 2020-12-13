<?php

namespace App\Http\Controllers;

use App\Facultad;
use App\Grupo;
use App\Http\Requests\ProgramaEducativoRequest;
use App\ProgramaEducativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProgramaEducativoController extends Controller
{
    public function index()
    {
        return view('ProgramaEducativo.index', [
            'programas' => ProgramaEducativo::get()
        ]);
    }

    public function create()
    {
        return view('ProgramaEducativo.create', [
            'programas' => new ProgramaEducativo(),
            'facultadoes' => Facultad::get()

        ]);
    }

    public function store(ProgramaEducativoRequest $request)
    {
        $request->validate([
            'NombreProgramaEducativo' => 'unique:Programa_Educativo,NombreProgramaEducativo'
        ]);
        try {
            ProgramaEducativo::create($request->validated());
            Session::flash('flash', [['type' => "success", 'message' => "Programa Educativo creado correctamente."]]);
            return redirect()->route('programaEducativo.index');
        } catch (\Throwable $throwable) {
            Session::flash('flash', [['type' => "danger", 'message' => "El Programa Educativo NO pudo ser creado correctamente."]]);
            return redirect()->route('programaEducativo.create');
        }
    }

    public function show(ProgramaEducativo $programaEducativo)
    {
        //
    }

    public function edit(ProgramaEducativo $programaEducativo)
    {
        return view('programaEducativo.edit', [
            'programas' => $programaEducativo,
            'facultadoes' => Facultad::get()
        ]);
    }

    public function update(ProgramaEducativoRequest $request, ProgramaEducativo $programaEducativo)
    {
        $request->validate([
            'NombreProgramaEducativo' => 'unique:Programa_Educativo,NombreProgramaEducativo,' . $programaEducativo->IdProgramaEducativo . ',IdProgramaEducativo',
            'AcronimoProgramaEducativo' => 'unique:Programa_Educativo,NombreProgramaEducativo,' . $programaEducativo->IdProgramaEducativo . ',IdProgramaEducativo'
        ]);
        try {
            $programaEducativo->update($request->validated());
            Session::flash('flash', [['type' => "success", 'message' => "Programa Educativo actualizado correctamente."]]);
            return redirect()->route('programaEducativo.index');
        } catch (\Throwable $throwable) {
            Session::flash('flash', [['type' => "danger", 'message' => "El Programa Educativo NO puede ser actualizado correctamente."]]);
            return redirect()->route('programaEducativo.edit', $programaEducativo->IdProgramaEducativo);
        }
    }

    public function destroy(ProgramaEducativo $programaEducativo)
    {
        try {
            $ocupado = Grupo::where('IdProgramaEducativo', $programaEducativo->IdProgramaEducativo)->count();
            if ($ocupado > 0) {
                Session::flash('flash', [['type' => "danger", 'message' => "El Programa Educativo " . $programaEducativo->AcronimoProgramaEducativo . " ya fue ocupado, no puede ser eliminado."]]);
                return redirect()->route('programaEducativo.index');
            } else {
                $programaEducativo->forceDelete();
                Session::flash('flash', [['type' => "success", 'message' => "El Programa Educativo fue eliminado correctamente."]]);
                return redirect()->route('programaEducativo.index');
            }
        } catch (\Throwable $throwable) {
            Session::flash('flash', [['type' => "danger", 'message' => "El Programa Educativo NO pudo ser eliminado correctamente."]]);
            return redirect()->route('programaEducativo.index');
        }
    }
}
