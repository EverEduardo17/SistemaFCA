<?php

namespace App\Http\Controllers;

use App\Estudiante;
use App\Grupo;
use App\Http\Requests\EstudianteRequest;
use App\Modalidad;
use App\Motivo;
use App\Motivos;
use App\Periodo;
use App\Practicas_Estudiante;
use App\ProgramaEducativo;
use App\Reprobados;
use App\Servicio_Social_Estudiante;
use App\Titulacion;
use App\Traslado;
use App\Trayectoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use MotivoSeeder;

class EstudianteController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(EstudianteRequest $request)
    {
        try {
            $input = $request->validated();
            $idGrupo = $input['IdGrupo'];

            $activos = DB::table('grupo')
                ->where('IdGrupo', $idGrupo)->value('EstudiantesActivos');
            $total = DB::table('grupo')
                ->where('IdGrupo', $idGrupo)->value('TotalEstudiantesGrupo');

            if (($activos + 1) <= $total) {
                DB::beginTransaction();

                $idEstudianteDB = DB::table('estudiante')->insertGetId([
                    'matriculaEstudiante'      => $input['MatriculaEstudiante']
                ]);

                $idDatosPersonales = DB::table('datospersonales')->insertGetId([
                    'NombreDatosPersonales'               => $input['NombreDatosPersonales'],
                    'ApellidoPaternoDatosPersonales'      => $input['ApellidoPaternoDatosPersonales'],
                    'ApellidoMaternoDatosPersonales'      => $input['ApellidoMaternoDatosPersonales'],
                    'Genero'                              => $input['Genero']
                ]);

                $idTrayectoria = DB::table('trayectoria')->insertGetId([
                    'EstudianteRegular' => 1,
                    'EstudianteActivo' => 1,
                    'TotalPeriodos' => 1,
                    'IdGrupo' => $input['IdGrupo'],
                    'IdEstudiante' => $idEstudianteDB,
                    'IdProgramaEducativo' => $input['IdProgramaEducativo'],
                    'IdModalidad' => $input['IdModalidad'],
                    'IdCohorte' => $input['IdCohorte'],
                    'IdDatosPersonales' => $idDatosPersonales
                ]);

                $idGrupoEstudiante = DB::table('grupo_estudiante')->insertGetId([
                    'IdGrupo' => $input['IdGrupo'],
                    'Estado' => 'Activo',
                    'IdTrayectoria' => $idTrayectoria
                ]);

                if (
                    $idEstudianteDB == null || $idEstudianteDB == 0 || $idDatosPersonales == null || $idDatosPersonales == 0
                    || $idTrayectoria == null || $idTrayectoria == 0 || $idGrupoEstudiante == null || $idGrupoEstudiante == 0
                ) {
                    DB::rollBack();
                    Session::flash('flash', [['type' => "danger", 'message' => "Error al registrar al Estudiante."]]);
                    return redirect()->route('estudiantes.show', $idGrupo);
                }
                DB::commit();
                DB::beginTransaction();
                DB::table('Grupo')->where('IdGrupo', $idGrupo)->update([
                    'EstudiantesActivos'       => ($activos + 1)
                ]);
                DB::commit();
            } else {
                DB::rollBack();
                Session::flash('flash', [['type' => "danger", 'message' => "Error al registrar al Estudiante, el grupo ya está completo."]]);
                return redirect()->route('estudiantes.show', $idGrupo);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            Session::flash('flash', [['type' => "danger", 'message' => "Error al registrar al Estudiante."]]);
            return redirect()->route('estudiantes.show', $idGrupo);
        }
        Session::flash('flash', [['type' => "success", 'message' => "Estudiante registrado correctamente."]]);
        return redirect()->route('estudiantes.show', $idGrupo);
    }

    public function show($idGrupo)
    {
        /*Nota:
         *   El código se hizo de esta manera debido a que apenas se está
         *   aprendiendo la tecnología y por cuestiones de tiempo se hizo
         *   con lo que se conocía en ese momento, no es lo mejor pero funciona ;).
         */
        $nombreGrupo = DB::table('grupo')
            ->where('IdGrupo', $idGrupo)->value('NombreGrupo');
        $idCohorte = DB::table('grupo')
            ->where('IdGrupo', $idGrupo)->value('IdCohorte');
        $nombreCohorte = DB::table('cohorte')
            ->where('IdCohorte', $idCohorte)->value('NombreCohorte');
        $idProgramaEducativo = DB::table('grupo')
            ->where('IdGrupo', $idGrupo)->value('IdProgramaEducativo');
        $programaEducativo = DB::table('programa_educativo')
            ->where('IdProgramaEducativo', $idProgramaEducativo)->value('AcronimoProgramaEducativo');
        $idFCA = DB::table('facultad')
            ->where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('idFacultad');
        return view('estudiantes.show', [
            'idGrupo' => $idGrupo,
            'nombreGrupo' => $nombreGrupo,
            'idCohorte' => $idCohorte,
            'nombreCohorte' => $nombreCohorte,
            'estudiantes' => Trayectoria::where('IdGrupo', $idGrupo)->get(),
            'cohortes' => DB::table('cohorte')
                ->orderBy('IdCohorte', 'desc')
                ->get(),
            'programas' => DB::table('programa_educativo')
                ->where('IdFacultad', $idFCA)
                ->get(),
            'grupos' => Grupo::get(),
            'modalidades' => Modalidad::get(),
            'idProgramaEducativo' => $idProgramaEducativo,
            'acronimoProgramaEducativo' => $programaEducativo,
            'periodos' => Periodo::get(),
            'motivos' => Motivo::get()
        ]);
    }

    public function mostrarEstudiante($idGrupo, $idTrayectoria)
    {
        $trayectoria = Trayectoria::where('IdTrayectoria',$idTrayectoria)->get();
        $reprobados = Reprobados::where('IdTrayectoria',$idTrayectoria)->get();
        $servicioSocial = Servicio_Social_Estudiante::where('IdTrayectoria',$idTrayectoria)->get();
        $practicas = Practicas_Estudiante::where('IdTrayectoria',$idTrayectoria)->get();
        $titulacion = Titulacion::where('IdTrayectoria',$idTrayectoria)->get();
        $movilidad = Traslado::where('IdTrayectoria',$idTrayectoria)->get();
        return view('estudiantes.mostrarEstudiante',[
            'trayectoria'   => $trayectoria,
            'reprobados'    => $reprobados,
            'servicio'      => $servicioSocial,
            'practicas'     => $practicas,
            'titulacion'    => $titulacion,
            'movilidad'    => $movilidad
        ]);
    }

    public function showEstudiante(Estudiante $estudiante)
    {
        /*
        @return va
        */
    }

    public function edit(Estudiante $estudiante)
    {
        //
    }

    public function update(Request $request, Estudiante $estudiante)
    {
        //
    }

    public function destroy(Estudiante $estudiante)
    {
        //
    }
}
