<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Http\Requests\ServicioSocialEstudianteRequest;
use App\Practicas_Estudiante;
use App\Servicio_Social_Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ServicioSocialEstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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
                Session::flash('flash', [['type' => "danger", 'message' => "La empresa no se encuentra registrada, para continuar agregue la empresa."]]);
                return redirect()->route('empresas.create');
            } else {
                $idEmpresa = Empresa::where('NombreEmpresa', '=', $input['NombreEmpresa'])->value('IdEmpresa');
                $servicio = Practicas_Estudiante::where("IdEmpresa", "=", $idEmpresa)->where("IdTrayectoria", "=", $input['IdTrayectoria'])->count();
                if ($servicio > 0) {
                    Session::flash('flash', [['type' => "danger", 'message' => "El estudiante ya está registrado en Prácticas Profesionales en esa empresa."]]);
                    return redirect()->back();
                } else {
                    try {
                        DB::beginTransaction();
                        DB::table('Servicio_Estudiante')->insert([
                            'IdTrayectoria' => $input['IdTrayectoria'],
                            'IdEmpresa'     => $idEmpresa
                        ]);
                        DB::commit();
                        Session::flash('flash', [['type' => "success", 'message' => "Servicio Social agregado correctamente."]]);
                        return redirect()->back();
                    } catch (\Throwable $throwable) {
                        dd($throwable);
                        Session::flash('flash', [['type' => "danger", 'message' => "El Servicio Social NO pudo ser agregado."]]);
                        return redirect()->back();
                    }
                }
            }
        } else {
            Session::flash('flash', [['type' => "danger", 'message' => "El estudiante ya cuenta con Servicio Social registrado."]]);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
