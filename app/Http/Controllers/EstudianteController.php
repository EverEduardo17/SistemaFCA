<?php

namespace App\Http\Controllers;

use App\Models\Cohorte;
use App\Models\DatosPersonales;
use App\Models\Estudiante;
use App\Models\Facultad;
use App\Models\Grupo;
use App\Models\Grupo_Estudiante;
use App\Http\Requests\EstudianteRequest;
use App\Models\Modalidad;
use App\Models\Motivo;
use App\Models\Motivos;
use App\Models\Periodo;
use App\Models\Practicas_Estudiante;
use App\Models\ProgramaEducativo;
use App\Models\Reprobado;

use App\Models\Servicio_Social_Estudiante;
use App\Models\Titulacion;
use App\Models\Traslado;
use App\Models\Trayectoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use MotivoSeeder;

class EstudianteController extends Controller
{
    public function agregarEstudiante($idGrupo)
    {
        $grupo = Grupo::where('IdGrupo', $idGrupo)->get()->last();
        $cohorte = Cohorte::where('IdCohorte', $grupo->IdCohorte)->get()->last();
        $programaEducativo = ProgramaEducativo::where('IdProgramaEducativo', $grupo->IdProgramaEducativo)->get()->last();
        $idFCA = Facultad::where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('IdFacultad');
        return view('estudiantes.crear', [
            'grupo'             => $grupo,
            'cohorte'           => $cohorte,
            'cohortes'          => Cohorte::orderBy('IdCohorte', 'desc')->get(),
            'programas'         => ProgramaEducativo::where('IdFacultad', $idFCA)->get(),
            'grupos'            => Grupo::where("IdFacultad", "=", $idFCA)->get(),
            'modalidades'       => Modalidad::where("TipoModalidad", "=", "Entrada")->get(),
            'programaEducativo' => $programaEducativo,
            'periodos'          => Periodo::get(),
            'motivos'           => Motivo::get()
        ]);
    }

    public function store(EstudianteRequest $request)
    {
        $existe = DatosPersonales::where([
            ['NombreDatosPersonales', '=', $request->NombreDatosPersonales],
            ['ApellidoPaternoDatosPersonales', '=', $request->ApellidoPaternoDatosPersonales],
            ['ApellidoMaternoDatosPersonales', '=', $request->ApellidoMaternoDatosPersonales],
        ])->count();
        if ($existe > 0) {
            $idDatos = DatosPersonales::where([
                ['NombreDatosPersonales', '=', $request->NombreDatosPersonales],
                ['ApellidoPaternoDatosPersonales', '=', $request->ApellidoPaternoDatosPersonales],
                ['ApellidoMaternoDatosPersonales', '=', $request->ApellidoMaternoDatosPersonales],
            ])->value("IdDatosPersonales");
            $existeTrayectoria = Trayectoria::where("IdDatosPersonales", "=", $idDatos)->get()->last();
            if ($existeTrayectoria != null) {
                if ($existeTrayectoria->IdGrupo == $request->IdGrupo) {
                    Session::flash('flash', [['type' => "danger", 'message' => "El estudiante ya se encuentra registrado en este grupo."]]);
                    return redirect()->route('estudiantesGrupo', $request->IdGrupo);
                }
            }
        }
        try {
            $input = $request->validated();
            $idGrupo = $input['IdGrupo'];

            DB::beginTransaction();

            $idEstudianteDB = DB::table('Estudiante')->insertGetId([
                'matriculaEstudiante'   => $input['MatriculaEstudiante']
            ]);

            $idDatosPersonales = DB::table('DatosPersonales')->insertGetId([
                'NombreDatosPersonales'               => $input['NombreDatosPersonales'],
                'ApellidoPaternoDatosPersonales'      => $input['ApellidoPaternoDatosPersonales'],
                'ApellidoMaternoDatosPersonales'      => $input['ApellidoMaternoDatosPersonales'],
                'Genero'                              => $input['Genero']
            ]);

            $idTrayectoria = DB::table('Trayectoria')->insertGetId([
                'EstudianteRegular'     => 1,
                'TotalPeriodos'         => 1,
                'IdGrupo'               => $input['IdGrupo'],
                'IdEstudiante'          => $idEstudianteDB,
                'IdProgramaEducativo'   => $input['IdProgramaEducativo'],
                'IdModalidad'           => $input['IdModalidad'],
                'IdCohorte'             => $input['IdCohorte'],
                'IdDatosPersonales'     => $idDatosPersonales
            ]);

            $idGrupoEstudiante = DB::table('Grupo_Estudiante')->insertGetId([
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
        $grupo = Grupo::where('IdGrupo', $idGrupo)->get()->last();
        $cohorte = Cohorte::where('IdCohorte', $grupo->IdCohorte)->get()->last();
        $programaEducativo = ProgramaEducativo::where('IdProgramaEducativo', $grupo->IdProgramaEducativo)->get()->last();
        $idFCA = Facultad::where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('IdFacultad');
        return view('estudiantes.show', [
            'grupo'             => $grupo,
            'cohorte'           => $cohorte,
            'estudiantes'       => Trayectoria::where('IdGrupo', $idGrupo)->get(),
            'cohortes'          => Cohorte::orderBy('IdCohorte', 'desc')->get(),
            'programas'         => ProgramaEducativo::where('IdFacultad', $idFCA)->get(),
            'grupos'            => Grupo::where("IdFacultad", "=", $idFCA)->get(),
            'modalidades'       => Modalidad::where("TipoModalidad", "=", "Entrada")->get(),
            'programaEducativo' => $programaEducativo,
            'periodos'          => Periodo::get(),
            'motivos'           => Motivo::get(),
            'estados'           => Grupo_Estudiante::where("IdGrupo", "=", $idGrupo)->get()
        ]);
    }

    public function mostrarEstudiante($idGrupo, $idTrayectoria)
    {
        $trayectoria = Trayectoria::where('IdTrayectoria', $idTrayectoria)->get()->last();
        $estado = Grupo_Estudiante::where('IdTrayectoria', $idTrayectoria)->value("Estado");
        $reprobados = Reprobado::where('IdTrayectoria', $idTrayectoria)->get()->last();
        $servicioSocial = Servicio_Social_Estudiante::where('IdTrayectoria', $idTrayectoria)->get()->last();
        $practicas = Practicas_Estudiante::where('IdTrayectoria', $idTrayectoria)->get()->last();
        $titulacion = Titulacion::where('IdTrayectoria', $idTrayectoria)->get()->last();
        $movilidad = Traslado::where('IdTrayectoria', $idTrayectoria)->get()->last();
        $periodos = Periodo::get();
        $motivos = Motivo::get();
        return view('estudiantes.mostrarEstudiante', [
            'trayectoria'   => $trayectoria,
            'reprobado'     => $reprobados,
            'servicio'      => $servicioSocial,
            'practicas'     => $practicas,
            'titulacion'    => $titulacion,
            'movilidad'     => $movilidad,
            'estado'        => $estado,
            'periodos'      => $periodos,
            'motivos'      => $motivos,
        ]);
    }

    public function editarEstudiante($idGrupo, $idTrayectoria)
    {
        $estado = Grupo_Estudiante::where("IdTrayectoria", "=", $idTrayectoria)->value("Estado");
        if ($estado == "Activo") {
            $trayectoria = Trayectoria::where('IdTrayectoria', $idTrayectoria)->get()->last();
            $estado = Grupo_Estudiante::where('IdTrayectoria', $idTrayectoria)->value("Estado");
            $reprobados = Reprobado::where('IdTrayectoria', $idTrayectoria)->get()->last();
            $servicioSocial = Servicio_Social_Estudiante::where('IdTrayectoria', $idTrayectoria)->get()->last();
            $practicas = Practicas_Estudiante::where('IdTrayectoria', $idTrayectoria)->get()->last();
            $titulacion = Titulacion::where('IdTrayectoria', $idTrayectoria)->get()->last();
            $movilidad = Traslado::where('IdTrayectoria', $idTrayectoria)->get()->last();
            $periodos = Periodo::get();
            $motivos = Motivo::get();
            $cohortes = Cohorte::orderBy('IdCohorte', 'desc')->get();
            $modalidades = Modalidad::get();
            $programas = ProgramaEducativo::where("IdFacultad", "=", Facultad::where("NombreFacultad", "=", "Facultad de Contaduría y Administración")->value("IdFacultad"))->get();
            $grupos = Grupo::where("IdCohorte", "=", $trayectoria->IdCohorte)->get();
            return view('estudiantes.edit', [
                'trayectoria'   => $trayectoria,
                'reprobado'     => $reprobados,
                'servicio'      => $servicioSocial,
                'practicas'     => $practicas,
                'titulacion'    => $titulacion,
                'movilidad'     => $movilidad,
                'estado'        => $estado,
                'periodos'      => $periodos,
                'motivos'       => $motivos,
                'cohortes'      => $cohortes,
                'modalidades'   => $modalidades,
                'programas'     => $programas,
                'grupos'        => $grupos,
            ]);
        } else {
            return redirect()->back();
        }
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
