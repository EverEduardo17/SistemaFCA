<?php

namespace App\Http\Controllers;

use App\Models\Facultad;
use App\Http\Requests\ProgramaEducativoRequest;
use App\Models\Empresa;
use App\Http\Requests\EmpresaRequest;
use App\Models\Practicas_Estudiante;
use App\Models\Servicio_Social_Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EmpresaController extends Controller
{

    public function index()
    {
        return view('empresa.index', [
            'empresas'  => Empresa::get()
        ]);
    }

    public function create()
    {
        return view('empresa.create', [
            'empresa'   => new Empresa()
        ]);
    }

    public function store(EmpresaRequest $request)
    {
        $request->validate([
            'NombreEmpresa'         => 'unique:Empresa,NombreEmpresa',
            'DireccionEmpresa'      => 'unique:Empresa,DireccionEmpresa',
            'TelefonoEmpresa'       => 'unique:Empresa,TelefonoEmpresa',
            'ResponsableEmpresa'    => 'unique:Empresa,ResponsableEmpresa'
        ]);
        try {
            Empresa::create($request->validated());
            Session::flash('flash', [['type' => "success", 'message' => "Empresa registrada correctamente."]]);
            return redirect()->route('empresas.index');
        } catch (\Throwable $throwable) {
            Session::flash('flash', [['type' => "danger", 'message' => "La Empresa NO pudo ser registrada."]]);
            return redirect()->route('empresas.create');
        }
    }

    public function show(Empresa $empresa)
    {
        return view('empresa.show', [
            'empresa'   => $empresa
        ]);
    }

    public function edit(Empresa $empresa)
    {
        return view('empresa.edit', [
            'empresa'   => $empresa
        ]);
    }

    public function update(EmpresaRequest $request, Empresa $empresa)
    {
        $request->validate([
            'NombreEmpresa'         => 'unique:Empresa,NombreEmpresa,' . $empresa->IdEmpresa . ',IdEmpresa',
            'DireccionEmpresa'      => 'unique:Empresa,DireccionEmpresa,' . $empresa->IdEmpresa . ',IdEmpresa',
            'TelefonoEmpresa'       => 'unique:Empresa,TelefonoEmpresa,' . $empresa->IdEmpresa . ',IdEmpresa',
            'ResponsableEmpresa'    => 'unique:Empresa,ResponsableEmpresa,' . $empresa->IdEmpresa . ',IdEmpresa',
        ]);
        try {
            $empresa->update($request->validated());
            Session::flash('flash', [['type' => "success", 'message' => "Empresa actualizada correctamente."]]);
            return redirect()->route('empresas.index');
        } catch (\Throwable $throwable) {
            Session::flash('flash', [['type' => "danger", 'message' => "La Empresa NO pudo ser actualizada correctamente."]]);
            return redirect()->route('empresas.edit', $empresa->IdEmpresa);
        }
    }

    public function destroy(Empresa $empresa)
    {
        try {
            $ocupadoPracticas   = Practicas_Estudiante::where('IdEmpresa', $empresa->IdEmpresa)->count();
            $ocupadoServicio    = Servicio_Social_Estudiante::where('IdEmpresa', $empresa->IdEmpresa)->count();
            if ($ocupadoPracticas > 0 || $ocupadoServicio > 0) {
                Session::flash('flash', [['type' => "danger", 'message' => "La empresa seleccionada ya está en uso, no puede ser eliminada."]]);
                return redirect()->route('empresas.index');
            } else {
                $empresa->forceDelete();
                Session::flash('flash', [['type' => "success", 'message' => "La empresa fue eliminada correctamente."]]);
                return redirect()->route('empresas.index');
            }
        } catch (\Throwable $throwable) {
            Session::flash('flash', [['type' => "danger", 'message' => "La empresa NO pudo ser eliminada."]]);
            return redirect()->route('empresas.edit', $empresa->IdEmpresa);
        }
    }
}
