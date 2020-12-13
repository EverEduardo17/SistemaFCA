<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BajaController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        dd($request);
        // try {
        //     $input = $request->validate([

        //     ]);
        //     $idGrupo = $input['Id'];

        //     $activos = DB::table('grupo')
        //         ->where('IdGrupo', $idGrupo)->value('EstudiantesActivos');
        //     $total = DB::table('grupo')
        //         ->where('IdGrupo', $idGrupo)->value('TotalEstudiantesGrupo');

        //     if (($activos + 1) <= $total) {
        //         DB::beginTransaction();

        //         $idEstudianteDB = DB::table('estudiante')->insertGetId([
        //             'matriculaEstudiante'      => $input['MatriculaEstudiante']
        //         ]);

        //         $idDatosPersonales = DB::table('datospersonales')->insertGetId([
        //             'NombreDatosPersonales'               => $input['NombreDatosPersonales'],
        //             'ApellidoPaternoDatosPersonales'      => $input['ApellidoPaternoDatosPersonales'],
        //             'ApellidoMaternoDatosPersonales'      => $input['ApellidoMaternoDatosPersonales'],
        //             'Genero'                              => $input['Genero']
        //         ]);

        //         $idTrayectoria = DB::table('trayectoria')->insertGetId([
        //             'EstudianteRegular' => 1,
        //             'EstudianteActivo' => 1,
        //             'TotalPeriodos' => 1,
        //             'IdGrupo' => $input['IdGrupo'],
        //             'IdEstudiante' => $idEstudianteDB,
        //             'IdProgramaEducativo' => $input['IdProgramaEducativo'],
        //             'IdModalidad' => $input['IdModalidad'],
        //             'IdCohorte' => $input['IdCohorte'],
        //             'IdDatosPersonales' => $idDatosPersonales
        //         ]);

        //         $idGrupoEstudiante = DB::table('grupo_estudiante')->insertGetId([
        //             'IdGrupo' => $input['IdGrupo'],
        //             'Estado' => 'Activo',
        //             'IdTrayectoria' => $idTrayectoria
        //         ]);

        //         if (
        //             $idEstudianteDB == null || $idEstudianteDB == 0 || $idDatosPersonales == null || $idDatosPersonales == 0
        //             || $idTrayectoria == null || $idTrayectoria == 0 || $idGrupoEstudiante == null || $idGrupoEstudiante == 0
        //         ) {
        //             DB::rollBack();
        //             Session::flash('flash', [['type' => "danger", 'message' => "Error al registrar al Estudiante."]]);
        //             return redirect()->route('estudiantes.show', $idGrupo);
        //         }
        //         DB::commit();
        //         DB::beginTransaction();
        //         DB::table('Grupo')->where('IdGrupo', $idGrupo)->update([
        //             'EstudiantesActivos'       => ($activos + 1)
        //         ]);
        //         DB::commit();
        //     } else {
        //         DB::rollBack();
        //         Session::flash('flash', [['type' => "danger", 'message' => "Error al registrar al Estudiante, el grupo ya está completo."]]);
        //         return redirect()->route('estudiantes.show', $idGrupo);
        //     }
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     dd($th);
        //     Session::flash('flash', [['type' => "danger", 'message' => "Error al registrar al Estudiante."]]);
        //     return redirect()->route('estudiantes.show', $idGrupo);
        // }
        // Session::flash('flash', [['type' => "success", 'message' => "Estudiante registrado correctamente."]]);
        // return redirect()->route('estudiantes.show', $idGrupo);


    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
