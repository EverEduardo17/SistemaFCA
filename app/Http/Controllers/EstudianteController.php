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
use App\Models\Practicas_Estudiante;
use App\Models\ProgramaEducativo;
use App\Models\Reprobado;

use App\Models\Servicio_Social_Estudiante;
use App\Models\Titulacion;
use App\Models\Traslado;
use App\Models\Trayectoria;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EstudianteController extends Controller
{

    public function index() 
    {
        $estudiantes = Estudiante::all();

        return view('estudiantes.index')->with('estudiantes', $estudiantes);
    }

    public function create() 
    {
        return view('estudiantes.create');
    }

    public function show($idGrupo)
    {
        
    }

    public function edit(Estudiante $estudiante) 
    {
        $cohortes = Cohorte::orderBy('NombreCohorte', 'desc')->get();
        $programasEducativos = ProgramaEducativo::orderBy('NombreProgramaEducativo', 'asc')->get();
        $modalidades = Modalidad::orderBy('NombreModalidad', 'asc')->get();
        $grupos = Grupo::orderBy('NombreGrupo', 'asc')->get();

        return view('estudiantes.edit', compact('estudiante', 'cohortes', 'programasEducativos', 'modalidades', 'grupos'));
    }


    public function agregarEstudiante($idGrupo)
    {
        $grupo              = Grupo::where('IdGrupo', $idGrupo)->get()->last();
        $cohorte            = Cohorte::where('IdCohorte', $grupo->IdCohorte)->get()->last();
        $idFCA              = Facultad::where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('IdFacultad');
        $programaEducativo  = ProgramaEducativo::where('IdProgramaEducativo', $grupo->IdProgramaEducativo)->get()->last();
        return view('grupos.estudiantes.create', [
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
            $timestamp = Carbon::now()->toDateTimeString();

            $matricula = $input['MatriculaEstudiante'];

            DB::beginTransaction();

            $idUsuarioDB = DB::table('Usuario')->insertGetId([
                'name'     => $matricula,
                'email'   => $matricula . '@estudiantes.uv.mx',
                'password' => bcrypt($matricula),
                'CreatedAt' => $timestamp,
                'UpdatedAt' => $timestamp,
            ]);

            $idEstudianteDB = DB::table('Estudiante')->insertGetId([
                'matriculaEstudiante'   => $matricula,
                'IdUsuario'   => $idUsuarioDB,
            ]);

            $idDatosPersonales = DB::table('DatosPersonales')->insertGetId([
                'NombreDatosPersonales'               => $input['NombreDatosPersonales'],
                'ApellidoPaternoDatosPersonales'      => $input['ApellidoPaternoDatosPersonales'],
                'ApellidoMaternoDatosPersonales'      => $input['ApellidoMaternoDatosPersonales'],
                'Genero'                              => $input['Genero'],
                'IdUsuario'   => $idUsuarioDB,
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


    public function update(EstudianteRequest $request, Estudiante $estudiante)
    {
        $request->validated();

        $estudiante->update($request->all());
        return redirect()->route('estudiantes.index');
    }

    public function destroy(Estudiante $estudiante)
    {
        //
    }
}
