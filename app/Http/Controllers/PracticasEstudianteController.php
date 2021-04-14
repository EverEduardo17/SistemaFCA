<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Http\Requests\PracticasEstudianteRequest;
use App\Http\Requests\ServicioSocialEstudianteRequest;
use App\Models\Practicas_Estudiante;
use App\Models\Servicio_Social_Estudiante;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PracticasEstudianteController extends Controller
{
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PracticasEstudianteRequest $request)
    {
        $input = $request->validated();
        $registrado = Practicas_Estudiante::where("IdTrayectoria", "=",$input['IdTrayectoria'])->count();
        if ($registrado == 0) {
            $existe = Empresa::where('NombreEmpresa', '=', $input['NombreEmpresa'])->count();
            if ($existe == 0) {
                Session::flash('flash', [['type' => "danger", 'message' => "La empresa ingresada no se encuentra registrada, para continuar registre la empresa."]]);
                return redirect()->back();
                // return redirect()->route('empresas.index');
            } else {
                $idEmpresa = Empresa::where('NombreEmpresa', '=', $input['NombreEmpresa'])->value('IdEmpresa');
                $servicio = Servicio_Social_Estudiante::where("IdEmpresa", "=", $idEmpresa)->where("IdTrayectoria", "=", $input['IdTrayectoria'])->count();
                if ($servicio > 0) {
                    Session::flash('flash', [['type' => "danger", 'message' => "El estudiante ya se encuentra registrado en Servicio Social en esa empresa."]]);
                    return redirect()->back();
                } else {
                    try {
                        DB::beginTransaction();
                        DB::table('Practica_Estudiante')->insert([
                            'IdTrayectoria' => $input['IdTrayectoria'],
                            'IdEmpresa'     => $idEmpresa
                        ]);
                        DB::commit();
                        Session::flash('flash', [['type' => "success", 'message' => "Práctica Profesional registrada correctamente."]]);
                        return redirect()->back();
                    } catch (\Throwable $throwable) {
                        dd($throwable);
                        Session::flash('flash', [['type' => "danger", 'message' => "La Práctica Profesional NO pudo ser registrada."]]);
                        return redirect()->back();
                    }
                }
            }
        } else {
            Session::flash('flash', [['type' => "danger", 'message' => "El estudiante ya cuenta con las Prácticas Profesionales registrada."]]);
            return redirect()->back();
        }
    }
}
