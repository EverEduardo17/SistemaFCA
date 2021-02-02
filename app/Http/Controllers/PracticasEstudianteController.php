<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Http\Requests\PracticasEstudianteRequest;
use App\Http\Requests\ServicioSocialEstudianteRequest;
use App\Models\Practicas_Estudiante;
use App\Models\Servicio_Social_Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PracticasEstudianteController extends Controller
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
    public function store(PracticasEstudianteRequest $request)
    {
        $input = $request->validated();
        $registrado = Practicas_Estudiante::where("IdTrayectoria", "=",$input['IdTrayectoria'])->count();
        if ($registrado == 0) {
            $existe = Empresa::where('NombreEmpresa', '=', $input['NombreEmpresa'])->count();
            if ($existe == 0) {
                Session::flash('flash', [['type' => "danger", 'message' => "La empresa no se encuentra registrada."]]);
                return redirect()->route('empresas.index');
            } else {
                $idEmpresa = Empresa::where('NombreEmpresa', '=', $input['NombreEmpresa'])->value('IdEmpresa');
                $servicio = Servicio_Social_Estudiante::where("IdEmpresa", "=", $idEmpresa)->where("IdTrayectoria", "=", $input['IdTrayectoria'])->count();
                if ($servicio > 0) {
                    Session::flash('flash', [['type' => "danger", 'message' => "El estudiante ya está registrado en Servicio Social en esa empresa."]]);
                    return redirect()->route('empresas.index');
                } else {
                    try {
                        DB::beginTransaction();
                        DB::table('Practica_Estudiante')->insert([
                            'IdTrayectoria' => $input['IdTrayectoria'],
                            'IdEmpresa'     => $idEmpresa
                        ]);
                        DB::commit();
                        Session::flash('flash', [['type' => "success", 'message' => "Práctica Profesional agregada correctamente."]]);
                        return redirect()->back();
                    } catch (\Throwable $throwable) {
                        dd($throwable);
                        Session::flash('flash', [['type' => "danger", 'message' => "La Práctica Profesional NO pudo ser agregada."]]);
                        return redirect()->back();
                    }
                }
            }
        } else {
            Session::flash('flash', [['type' => "danger", 'message' => "El estudiante ya cuenta con Prácticas Profesionales registradas."]]);
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
