<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Http\Requests\ServicioSocialEstudianteRequest;
use App\Models\Practicas_Estudiante;
use App\Models\Servicio_Social_Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ServicioSocialEstudianteController extends Controller
{
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServicioSocialEstudianteRequest $request)
    {
        $input = $request->validated();
        $registrado = Servicio_Social_Estudiante::where("IdTrayectoria", "=", $input['IdTrayectoria'])->count();
        if ($registrado == 0) {
            $existe = Empresa::where('NombreEmpresa', '=', $input['NombreEmpresa'])->count();
            if ($existe == 0) {
                Session::flash('flash', [['type' => "danger", 'message' => "La empresa ingresada no se encuentra registrada, para continuar registre la empresa."]]);
                return redirect()->back();
                // return redirect()->route('empresas.create');
            } else {
                $idEmpresa = Empresa::where('NombreEmpresa', '=', $input['NombreEmpresa'])->value('IdEmpresa');
                $servicio = Practicas_Estudiante::where("IdEmpresa", "=", $idEmpresa)->where("IdTrayectoria", "=", $input['IdTrayectoria'])->count();
                if ($servicio > 0) {
                    Session::flash('flash', [['type' => "danger", 'message' => "El estudiante ya se encuentra registrado en Prácticas Profesionales en esa empresa."]]);
                    return redirect()->back();
                } else {
                    try {
                        DB::beginTransaction();
                        DB::table('Servicio_Estudiante')->insert([
                            'IdTrayectoria' => $input['IdTrayectoria'],
                            'IdEmpresa'     => $idEmpresa
                        ]);
                        DB::commit();
                        Session::flash('flash', [['type' => "success", 'message' => "Servicio Social registrado correctamente."]]);
                        return redirect()->back();
                    } catch (\Throwable $throwable) {
                        Session::flash('flash', [['type' => "danger", 'message' => "El Servicio Social NO pudo ser registrado."]]);
                        return redirect()->back();
                    }
                }
            }
        } else {
            Session::flash('flash', [['type' => "danger", 'message' => "El estudiante ya cuenta con el Servicio Social registrado."]]);
            return redirect()->back();
        }
    }

}
