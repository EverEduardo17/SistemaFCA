<?php

namespace App\Http\Controllers;

use App\Facultad;
use App\Http\Requests\ProgramaEducativoRequest;
use App\Empresa;
use App\Http\Requests\EmpresaRequest;
use App\Practicas_Estudiante;
use App\Servicio_Social_Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Empresa.index', [
            'empresas' => Empresa::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Empresa.create', [
            'empresa' => new Empresa()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmpresaRequest $request)
    {
        $request->validate([
            'NombreEmpresa' => 'unique:Empresa,NombreEmpresa',
            'DireccionEmpresa' => 'unique:Empresa,DireccionEmpresa',
            'TelefonoEmpresa' => 'unique:Empresa,TelefonoEmpresa',
            'ResponsableEmpresa' => 'unique:Empresa,ResponsableEmpresa'
        ]);
        try {
            Empresa::create($request->validated());
            Session::flash('flash', [['type' => "success", 'message' => "Empresa creada correctamente."]]);
            return redirect()->route('empresas.index');
        } catch (\Throwable $throwable) {
            dd($throwable);
            Session::flash('flash', [['type' => "danger", 'message' => "La Empresa NO pudo ser creada correctamente."]]);
            return redirect()->route('empresas.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresa $empresa)
    {
        return view('empresa.show', [
            'empresa' => $empresa
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function edit(Empresa $empresa)
    {
        return view('empresa.edit', [
            'empresa' => $empresa
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empresa  $programaEducativo
     * @return \Illuminate\Http\Response
     */
    public function update(EmpresaRequest $request, Empresa $empresa)
    {
        $request->validate([
            'NombreEmpresa' => 'unique:Empresa,NombreEmpresa,' . $empresa->IdEmpresa . ',IdEmpresa',
            'DireccionEmpresa' => 'unique:Empresa,DireccionEmpresa,' . $empresa->IdEmpresa . ',IdEmpresa',
            'TelefonoEmpresa' => 'unique:Empresa,TelefonoEmpresa,' . $empresa->IdEmpresa . ',IdEmpresa',
            'ResponsableEmpresa' => 'unique:Empresa,ResponsableEmpresa,' . $empresa->IdEmpresa . ',IdEmpresa',
        ]);
        try {
            $empresa->update($request->validated());
            Session::flash('flash', [['type' => "success", 'message' => "Empresa actualizada correctamente."]]);
            return redirect()->route('empresas.index');
        } catch (\Throwable $throwable) {
            dd($throwable);
            Session::flash('flash', [['type' => "danger", 'message' => "La Empresa NO puede ser actualizada correctamente."]]);
            return redirect()->route('empresas.edit', $empresa->IdEmpresa);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa)
    {
        try {
            $ocupadoPracticas = Practicas_Estudiante::where('IdPractica', $empresa->IdEmpresa)->count();
            $ocupadoServicio = Servicio_Social_Estudiante::where('IdServicioSocial', $empresa->IdEmpresa)->count();
            if ($ocupadoPracticas > 0 || $ocupadoServicio > 0) {
                Session::flash('flash', [['type' => "danger", 'message' => "Esta empresa ya está en uso, no puede ser eliminado."]]);
                return redirect()->route('sedeEventos.index');
            } else {
                $empresa->forceDelete();
                Session::flash('flash', [['type' => "success", 'message' => "La empresa fue eliminada correctamente."]]);
                return redirect()->route('empresas.index');
            }
        } catch (\Throwable $throwable) {
            dd($throwable);
            Session::flash('flash', [['type' => "danger", 'message' => "La empresa NO pudo ser eliminada correctamente."]]);
            return redirect()->route('empresas.edit', $empresa->IdEmpresa);
        }
    }
}