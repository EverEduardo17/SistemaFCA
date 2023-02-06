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
        $grupo              = Grupo::where('IdGrupo', $idGrupo)->get()->last();
        $cohorte            = Cohorte::where('IdCohorte', $grupo->IdCohorte)->get()->last();
        $idFCA              = Facultad::where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('IdFacultad');
        $programaEducativo  = ProgramaEducativo::where('IdProgramaEducativo', $grupo->IdProgramaEducativo)->get()->last();
        return view('estudiantes.crear', [
            'grupo'             => $grupo,
            'cohorte'           => $cohorte,
            'cohortes'          => Cohorte::orderBy('IdCohorte', 'desc')->get(),
            'programas'         => ProgramaEducativo::where('IdFacultad', $idFCA)->get(),
            'grupos'            => Grupo::where("IdFacultad", "=", $idFCA)->get(),
            'modalidades'       => Modalidad::where("TipoModalidad", "=", "Entrada")->get(),
            'programaEducativo' => $programaEducativo,
            'periodos'          => DB::table('Periodo')
                ->orderBy('IdPeriodo', 'desc')
                ->get(),
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
            if ($existeTrayectoria != null && $existeTrayectoria->IdGrupo == $request->IdGrupo) {
                Session::flash('flash', [['type' => "danger", 'message' => "El estudiante ya se encuentra registrado en el grupo seleccionado."]]);
                return redirect()->route('estudiantes.show', $request->IdGrupo);
            }
        }
        $matricula = $request->MatriculaEstudiante;
        $cohorte = Cohorte::where('IdCohorte', '=', $request->IdCohorte)->value('NombreCohorte');
        if (strpos($matricula, $cohorte) !== 0) {
            Session::flash('flash', [['type' => "danger", 'message' => "La matrícula ingresada no corresponde al cohorte seleccionado."]]);
            return redirect()->route('estudiantes.agregarEstudiante');
        }

        //<---- Verifica si es un traslado  ---->
        $tipoEntrada = $request->IdModalidad;
        if ($tipoEntrada == 4) {
            $request->validate([
                'NombreFacultad'   => ['required', 'String', 'regex:/^[A-Za-zÁáéÉíÍóÓúÚüÜñÑ.]+(\s{1}[A-Za-záÁéÉíÍóÓúÚüÜñÑ.]+)*$/'],
                'NombreCampus'     => ['required', 'String', 'regex:/^[A-Za-zÁáéÉíÍóÓúÚüÜñÑ.]+(\s{1}[A-Za-záÁéÉíÍóÓúÚüÜñÑ.]+)*$/']
            ]);
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

            //<---- Verifica si es un traslado y guarda el registro ---->
            if ($tipoEntrada == 4) {
                $idGrupoEstudiante = DB::table('Grupo_Estudiante')->insertGetId([
                    'Estado'        => 'Activo',
                    'TipoTraslado'  => 'Entrante',
                    'IdGrupo'       => $input['IdGrupo'],
                    'IdTrayectoria' => $idTrayectoria
                ]);
                //<---- Obtine el último periodo activo del Grupo ---->
                $traslado = $request->validate([
                    'NombreFacultad'   => ['required', 'String', 'regex:/^[A-Za-zÁáéÉíÍóÓúÚüÜñÑ.]+(\s{1}[A-Za-záÁéÉíÍóÓúÚüÜñÑ.]+)*$/'],
                    'NombreCampus'     => ['required', 'String', 'regex:/^[A-Za-zÁáéÉíÍóÓúÚüÜñÑ.]+(\s{1}[A-Za-záÁéÉíÍóÓúÚüÜñÑ.]+)*$/']
                ]);
                $periodoActivo = Grupo::where('IdGrupo', '=', $input['IdGrupo'])->value('IdPeriodoActivo');
                $idTraslado = DB::table('Traslado')->insertGetId([
                    'FacultadDestino'   => $traslado['NombreFacultad'],
                    'CampusDestino'     => $traslado['NombreCampus'],
                    'IdGrupo'           => $input['IdGrupo'],
                    'IdTrayectoria'     => $idTrayectoria,
                    'IdPeriodo'         => $periodoActivo
                ]);

                if (
                    $idEstudianteDB == null || $idEstudianteDB == 0 || $idDatosPersonales == null || $idDatosPersonales == 0
                    || $idTrayectoria == null || $idTrayectoria == 0 || $idGrupoEstudiante == null || $idGrupoEstudiante == 0
                    || $idTraslado == null || $idTraslado == 0
                ) {
                    DB::rollBack();
                    Session::flash('flash', [['type' => "danger", 'message' => "El estudiante NO pudo ser registrado."]]);
                    return redirect()->route('estudiantes.show', $idGrupo);
                }
                DB::commit();
            } else {
                $idGrupoEstudiante = DB::table('Grupo_Estudiante')->insertGetId([
                    'IdGrupo'       => $input['IdGrupo'],
                    'Estado'        => 'Activo',
                    'IdTrayectoria' => $idTrayectoria
                ]);

                if (
                    $idEstudianteDB == null || $idEstudianteDB == 0 || $idDatosPersonales == null || $idDatosPersonales == 0
                    || $idTrayectoria == null || $idTrayectoria == 0 || $idGrupoEstudiante == null || $idGrupoEstudiante == 0
                ) {
                    DB::rollBack();
                    Session::flash('flash', [['type' => "danger", 'message' => "El estudiante NO pudo ser registrado."]]);
                    return redirect()->route('estudiantes.show', $idGrupo);
                }
                DB::commit();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            Session::flash('flash', [['type' => "danger", 'message' => "El estudiante NO pudo ser registrado."]]);
            return redirect()->route('estudiantes.show', $idGrupo);
        }
        Session::flash('flash', [['type' => "success", 'message' => "Estudiante registrado correctamente."]]);
        return redirect()->route('estudiantes.show', $idGrupo);
    }

    public function show($idGrupo)
    {
        $grupo              = Grupo::where('IdGrupo', $idGrupo)->get()->last();
        $cohorte            = Cohorte::where('IdCohorte', $grupo->IdCohorte)->get()->last();
        $idFCA              = Facultad::where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('IdFacultad');        $programaEducativo  = ProgramaEducativo::where('IdProgramaEducativo', $grupo->IdProgramaEducativo)->get()->last();
        return view('estudiantes.show', [
            'grupo'             => $grupo,
            'cohorte'           => $cohorte,
            'estudiantes'       => Trayectoria::where('IdGrupo', $idGrupo)->get(),
            'cohortes'          => Cohorte::orderBy('IdCohorte', 'desc')->get(),
            'programas'         => ProgramaEducativo::where('IdFacultad', $idFCA)->get(),
            'grupos'            => Grupo::where("IdFacultad", "=", $idFCA)->get(),
            'modalidades'       => Modalidad::where("TipoModalidad", "=", "Entrada")->get(),
            'programaEducativo' => $programaEducativo,
            'periodos'          => DB::table('Periodo')
                ->orderBy('IdPeriodo', 'desc')
                ->get(),
            'motivos'           => Motivo::get(),
            'estados'           => Grupo_Estudiante::where("IdGrupo", "=", $idGrupo)->get()
        ]);
    }

    public function mostrarEstudiante($idGrupo, $matriculaEstudiante)
    {
        $idEstudiante   = Estudiante::where('MatriculaEstudiante', '=', $matriculaEstudiante)->value('IdEstudiante');
        $idTrayectoria  = Trayectoria::where('IdEstudiante', '=', $idEstudiante)->value('IdTrayectoria');
        $estado         = Grupo_Estudiante::where('IdTrayectoria', $idTrayectoria)->value("Estado");
        $motivos        = Motivo::get();
        $movilidad      = Traslado::where('IdTrayectoria', $idTrayectoria)->get()->last();
        $periodos       = DB::table('Periodo')
            ->orderBy('IdPeriodo', 'desc')
            ->get();
        $practicas      = Practicas_Estudiante::where('IdTrayectoria', $idTrayectoria)->get()->last();
        $reprobados     = Reprobado::where('IdTrayectoria', $idTrayectoria)->get()->last();
        $servicioSocial = Servicio_Social_Estudiante::where('IdTrayectoria', $idTrayectoria)->get()->last();
        $titulacion     = Titulacion::where('IdTrayectoria', $idTrayectoria)->get()->last();
        $trayectoria    = Trayectoria::where('IdTrayectoria', $idTrayectoria)->get()->last();
        return view('estudiantes.mostrarEstudiante', [
            'trayectoria'   => $trayectoria,
            'reprobado'     => $reprobados,
            'servicio'      => $servicioSocial,
            'practicas'     => $practicas,
            'titulacion'    => $titulacion,
            'movilidad'     => $movilidad,
            'estado'        => $estado,
            'periodos'      => $periodos,
            'motivos'       => $motivos,
        ]);
    }

    public function editarEstudiante($idGrupo, $idTrayectoria)
    {

        $trayectoria    = Trayectoria::where('IdTrayectoria', $idTrayectoria)->get()->last();

        $cohortes       = Cohorte::orderBy('IdCohorte', 'desc')->get();
        $estado         = Grupo_Estudiante::where('IdTrayectoria', $idTrayectoria)->value("Estado");
        $grupos         = Grupo::where("IdCohorte", "=", $trayectoria->IdCohorte)->get();
        $motivos        = Motivo::get();
        $movilidad      = Traslado::where('IdTrayectoria', $idTrayectoria)->get()->last();
        $periodoInicio  = $grupos[0]->IdPeriodoInicio;
        $periodos       = DB::table('Periodo')
            ->whereBetween('IdPeriodo', array($periodoInicio, $periodoInicio + 9))
            ->orderBy('IdPeriodo', 'desc')
            ->get();
        $practicas      = Practicas_Estudiante::where('IdTrayectoria', $idTrayectoria)->get()->last();
        $programas      = ProgramaEducativo::where("IdFacultad", "=", Facultad::where("NombreFacultad", "=", "Facultad de Contaduría y Administración")->value("IdFacultad"))->get();
        $reprobados     = Reprobado::where('IdTrayectoria', $idTrayectoria)->get()->last();
        $servicioSocial = Servicio_Social_Estudiante::where('IdTrayectoria', $idTrayectoria)->get()->last();
        $titulacion     = Titulacion::where('IdTrayectoria', $idTrayectoria)->get()->last();
        //TODO: Limitar la modalidad si no es LSCA o LIS
        /*
$idLIS              = ProgramaEducativo::where('AcronimoProgramaEducativo', '=','LIS')->value('IdProgramaEducativo');
        $idLSCA              = ProgramaEducativo::where('AcronimoProgramaEducativo', '=','LSCA')->value('IdProgramaEducativo');

        if($grupo[0]->IdProgramaEducativo == $idLIS || $grupo[0]->IdProgramaEducativo == $idLSCA ){
            $modalidades        = Modalidad::where('TipoModalidad', '=', 'Titulación')->get();
        }else{
            $modalidades        = Modalidad::where('TipoModalidad', '=', 'Titulación')->where('NombreModalidad', '<>', 'Trabajo Práctico')->get();
        }
*/


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
            'modalidades'   => Modalidad::get(),
            'programas'     => $programas,
            'grupos'        => $grupos,
        ]);
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
