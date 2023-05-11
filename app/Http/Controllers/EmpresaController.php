<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Http\Requests\EmpresaRequest;
use App\Models\Practicas_Estudiante;
use App\Models\Servicio_Social_Estudiante;
use Illuminate\Support\Facades\Session;

class EmpresaController extends Controller
{

    public function index()
    {
        \Gate::authorize('havepermiso', 'empresas-listar');

        $empresas       = Empresa::get();
        $nombreEmpresas = [];
        $contador       = 0;
        foreach($empresas as $empresa){
            $nombreEmpresas[$contador] = str_replace(" ", "-", $empresa->NombreEmpresa);
            $contador++;
        }
        return view('empresa.index', [
            'empresas'          => $empresas,
            'nombreEmpresas'    => $nombreEmpresas,
        ]);
    }

    public function create()
    {
        \Gate::authorize('havepermiso', 'empresas-crear');

        return view('empresa.create', [
            'empresa'   => new Empresa()
        ]);
    }

    public function store(EmpresaRequest $request)
    {
        $request->validate([
            'NombreEmpresa'         => 'unique:Empresa,NombreEmpresa',
            //TODO: preguntar de estas validaciones.
            // 'DireccionEmpresa'      => 'unique:Empresa,DireccionEmpresa',
            // 'TelefonoEmpresa'       => 'unique:Empresa,TelefonoEmpresa',
            // 'ResponsableEmpresa'    => 'unique:Empresa,ResponsableEmpresa'
        ]);
        try {
            $input = $request->validated();
            if ($request->TipoEmpresa != 'UV') {
                if ($request->ClasificacionEmpresa == null || $request->ActividadEmpresa == null) {
                    Session::flash('flash', [['type' => "danger", 'message' => "Rellena todos los campos para continuar."]]);
                    return redirect()->back()->withInput();
                } else {
                    $input['ClasificacionEmpresa']  = $request->ClasificacionEmpresa;
                    $input['ActividadEmpresa']  = $request->ActividadEmpresa;
                }
            } else {
                $input['ClasificacionEmpresa']  = 'Grande';
                $input['ActividadEmpresa']      = 'Servicios';
            }
            Empresa::create($input);
            Session::flash('flash', [['type' => "success", 'message' => "Empresa registrada correctamente."]]);
            return redirect()->route('empresas.index');
        } catch (\Throwable $throwable) {
            dd($throwable);
            Session::flash('flash', [['type' => "danger", 'message' => "La Empresa NO pudo ser registrada."]]);
            return redirect()->back();
        }
    }

    public function show($nombreEmpresa)
    {
        \Gate::authorize('havepermiso', 'empresas-ver-propio');

        $nombreLimpio = str_replace("-", " ", $nombreEmpresa);
        $empresa = Empresa::where('NombreEmpresa', '=', $nombreLimpio)->get()->last();
        return view('empresa.show', [
            'empresa'   => $empresa,
            'nombreEmpresa' => $nombreEmpresa,
        ]);
    }

    public function edit($nombreEmpresa)
    {
        \Gate::authorize('havepermiso', 'empresas-editar-propio');

        $nombreLimpio = str_replace("-", " ", $nombreEmpresa);
        $empresa = Empresa::where('NombreEmpresa', '=', $nombreLimpio)->get()->last();
        return view('empresa.edit', [
            'empresa'       => $empresa,
            'nombreEmpresa' => $nombreEmpresa,
        ]);
    }

    public function update(EmpresaRequest $request, Empresa $empresa)
    {
        $request->validate([
            'NombreEmpresa'         => 'unique:Empresa,NombreEmpresa,' . $empresa->IdEmpresa . ',IdEmpresa',
            // 'DireccionEmpresa'      => 'unique:Empresa,DireccionEmpresa,' . $empresa->IdEmpresa . ',IdEmpresa',
            // 'TelefonoEmpresa'       => 'unique:Empresa,TelefonoEmpresa,' . $empresa->IdEmpresa . ',IdEmpresa',
            // 'ResponsableEmpresa'    => 'unique:Empresa,ResponsableEmpresa,' . $empresa->IdEmpresa . ',IdEmpresa',
        ]);
        try {
            $input = $request->validated();
            if ($request->TipoEmpresa != 'UV') {
                if ($request->ClasificacionEmpresa == null || $request->ActividadEmpresa == null) {
                    Session::flash('flash', [['type' => "danger", 'message' => "Rellena todos los campos para continuar."]]);
                    return redirect()->back()->withInput();
                } else {
                    $input['ClasificacionEmpresa']  = $request->ClasificacionEmpresa;
                    $input['ActividadEmpresa']  = $request->ActividadEmpresa;
                }
            } else {
                $input['ClasificacionEmpresa']  = 'Grande';
                $input['ActividadEmpresa']      = 'Servicios';
            }

            $empresa->update($input);
            Session::flash('flash', [['type' => "success", 'message' => "Empresa actualizada correctamente."]]);
            return redirect()->route('empresas.index');
        } catch (\Throwable $throwable) {
            Session::flash('flash', [['type' => "danger", 'message' => "La Empresa NO pudo ser actualizada correctamente."]]);
            return redirect()->route('empresas.edit', $empresa->IdEmpresa);
        }
    }

    public function destroy(Empresa $empresa)
    {
        \Gate::authorize('havepermiso', 'empresas-eliminar-propio');

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
