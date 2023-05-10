<?php

namespace App\Http\Controllers;

use App\Models\Facultad;
use App\Models\Grupo;
use App\Models\ProgramaEducativo;
use App\Http\Requests\ProgramaEducativoRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class ProgramaEducativoController extends Controller
{
    public function index()
    {
        // Gate::authorize('havepermiso', 'programaEducativo-listar');    // en un futuro si se hacen los permisos nuevos

        $idFCA = Facultad::where("NombreFacultad", "=", "Facultad de Contaduría y Administración")->value("IdFacultad");
        return view('programaEducativo.index', [
            'programas' => ProgramaEducativo::where("IdFacultad", "=", $idFCA)->get(),
        ]);

        /* testear luego de actualizar las migraciones
         
        $facultad = Facultad::where("NombreFacultad", "=", "Facultad de Contaduría y Administración")->firstOrFail();
        $programas = $facultad->programasEducativos;
        return view('programaEducativo.index', compact('programas'));
        */
    }

    public function create()
    {
        Gate::authorize('havepermiso', 'programaEducativo-crear');

        return view('programaEducativo.create', [
            'programas' => new ProgramaEducativo(),
            'facultad'  => Facultad::where("NombreFacultad", "=", "Facultad de Contaduría y Administración")->get()
        ]);
    }

    public function store(ProgramaEducativoRequest $request)
    {
        $request->validate([
            'NombreProgramaEducativo' => 'unique:Programa_Educativo,NombreProgramaEducativo',
            'AcronimoProgramaEducativo' => 'unique:Programa_Educativo,AcronimoProgramaEducativo'
        ]);
        try {
            ProgramaEducativo::create($request->validated());

            Session::flash('flash', [['type' => "success", 'message' => "Programa Educativo registrado correctamente."]]);
            return redirect()->route('programaEducativo.index');
        } catch (\Throwable $throwable) {
            Session::flash('flash', [['type' => "danger", 'message' => "El Programa Educativo NO pudo ser registrado."]]);
            return redirect()->route('programaEducativo.create');
        }
    }

    public function edit($acronimoPrograma)
    {
        Gate::authorize('havepermiso', 'programaEducativo-editar');
        
        $programaEducativo = ProgramaEducativo::where('AcronimoProgramaEducativo', '=', $acronimoPrograma)->get()->last();
        return view('programaEducativo.edit', [
            'programas' => $programaEducativo,
            'facultad'  => Facultad::where("NombreFacultad", "=", "Facultad de Contaduría y Administración")->get()
        ]);
    }

    public function update(ProgramaEducativoRequest $request, ProgramaEducativo $programaEducativo)
    {
        $request->validate([
            'NombreProgramaEducativo'   => 'unique:Programa_Educativo,NombreProgramaEducativo,' . $programaEducativo->IdProgramaEducativo . ',IdProgramaEducativo',
            'AcronimoProgramaEducativo' => 'unique:Programa_Educativo,AcronimoProgramaEducativo,' . $programaEducativo->IdProgramaEducativo . ',IdProgramaEducativo'
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
        Gate::authorize('havepermiso', 'programaEducativo-eliminar');

        try {
            $ocupado = Grupo::where('IdProgramaEducativo', $programaEducativo->IdProgramaEducativo)->count();
            if ($ocupado > 0) {
                Session::flash('flash', [['type' => "danger", 'message' => "El Programa Educativo '" . $programaEducativo->AcronimoProgramaEducativo . "' ya se encuentra en uso, no puede ser eliminado."]]);
                return redirect()->route('programaEducativo.index');
            } else {
                $programaEducativo->delete();
                Session::flash('flash', [['type' => "success", 'message' => "El Programa Educativo fue eliminado correctamente."]]);
                return redirect()->route('programaEducativo.index');
            }
        } catch (\Throwable $throwable) {
            Session::flash('flash', [['type' => "danger", 'message' => "El Programa Educativo NO pudo ser eliminado."]]);
            return redirect()->route('programaEducativo.index');
        }
    }
}
