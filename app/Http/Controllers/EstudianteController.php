<?php

namespace App\Http\Controllers;

use App\Models\Cohorte;
use App\Models\DatosPersonales;
use App\Models\Estudiante;
use App\Models\Facultad;
use App\Models\Grupo;
use App\Http\Requests\EstudianteRequest;
use App\Models\Modalidad;
use App\Models\Motivo;
use App\Models\ProgramaEducativo;

use App\Models\Trayectoria;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class EstudianteController extends Controller
{

    public function index() 
    {
        \Gate::authorize('havepermiso', 'estudiante-ver-todos-propio');

        $estudiantes = Estudiante::all();

        return view('estudiantes.index')->with('estudiantes', $estudiantes);
    }

    public function create() 
    {
        Gate::authorize('havepermiso', 'estudiante-crear');

        $cohortes = Cohorte::orderBy('NombreCohorte', 'desc')->get();
        $grupos = Grupo::orderBy('NombreGrupo', 'asc')->get();
        $modalidades = Modalidad::orderBy('NombreModalidad', 'asc')->get();
        $programasEducativos = ProgramaEducativo::orderBy('NombreProgramaEducativo', 'asc')->get();
        $grupos = Grupo::orderBy('NombreGrupo', 'asc')->get();

        return view('estudiantes.create', compact('cohortes', 'grupos', 'modalidades', 'programasEducativos'));
    }

    public function show(Estudiante $estudiante)
    {
        Gate::authorize('havepermiso', 'estudiante-ver-propio');

        return view('estudiantes.show', compact('estudiante'));   
    }

    public function edit(Estudiante $estudiante) 
    {
        Gate::authorize('havepermiso', 'estudiante-editar-propio');

        $cohortes = Cohorte::orderBy('NombreCohorte', 'desc')->get();
        $programasEducativos = ProgramaEducativo::orderBy('NombreProgramaEducativo', 'asc')->get();
        $modalidades = Modalidad::orderBy('NombreModalidad', 'asc')->get();
        $grupos = Grupo::orderBy('NombreGrupo', 'asc')->get();

        return view('estudiantes.edit', compact('estudiante', 'cohortes', 'programasEducativos', 'modalidades', 'grupos'));
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
            return redirect()->route('estudiantes.create');
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
                'email'   => 'z' . $matricula . '@estudiantes.uv.mx',
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
            DB::commit();

        } catch (\Throwable $th) {

            DB::rollBack();
            dd($th);
            Session::flash('flash', [['type' => "danger", 'message' => "El estudiante NO pudo ser registrado."]]);
            return redirect()->route('estudiantes.index');
        }

        Session::flash('flash', [['type' => "success", 'message' => "Estudiante registrado correctamente."]]);
        return redirect()->route('estudiantes.index');
    }


    public function update(EstudianteRequest $request, Estudiante $estudiante)
    {
        $request->validated();

        $estudiante->update($request->all());
        $estudiante->trayectoria->datosPersonales->update($request->all());
        
        $estudiante->trayectoria->update($request->all());
        

        return redirect()->route('estudiantes.index');
    }

    public function destroy(Estudiante $estudiante)
    {
        Gate::authorize('havepermiso', 'estudiante-eliminar-propio');

        //
    }

    
}
