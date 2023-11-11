<?php

namespace App\Http\Controllers;

use App\Models\Cohorte;
use App\Models\DatosPersonales;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Http\Requests\EstudianteRequest;
use App\Models\Modalidad;
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
        Gate::authorize('havepermiso', 'estudiante-ver-propio');

        $cohortes = Cohorte::orderBy('NombreCohorte', 'desc')->get();
        //$grupos = Grupo::orderBy('NombreGrupo', 'asc')->get();
        $modalidades = Modalidad::orderBy('NombreModalidad', 'asc')->get();
        $programasEducativos = ProgramaEducativo::orderBy('NombreProgramaEducativo', 'asc')->get();
        //$grupos = Grupo::orderBy('NombreGrupo', 'asc')->get();

        //return view('estudiantes.create', compact('cohortes', 'grupos', 'modalidades', 'programasEducativos'));
        return view('estudiantes.create', compact('cohortes', 'modalidades', 'programasEducativos'));
    }

    public function show(Estudiante $estudiante)
    {
        Gate::authorize('havepermiso', 'estudiante-ver-propio');

        return view('estudiantes.show', compact('estudiante'));   
    }

    public function edit(Estudiante $estudiante) 
    {
        Gate::authorize('havepermiso', 'estudiante-ver-propio');

        $cohortes = Cohorte::orderBy('NombreCohorte', 'desc')->get();
        $programasEducativos = ProgramaEducativo::orderBy('NombreProgramaEducativo', 'asc')->get();
        $modalidades = Modalidad::orderBy('NombreModalidad', 'asc')->get();
        $grupos = Grupo::orderBy('NombreGrupo', 'asc')->get();

        return view('estudiantes.edit', compact('estudiante', 'cohortes', 'programasEducativos', 'modalidades', 'grupos'));
    }

    public function store(EstudianteRequest $request)
    {
        Gate::authorize('havepermiso', 'estudiante-crear');
     
        try {
            $input = $request->validated();
            //$idGrupo = $input['IdGrupo'];
            $timestamp = Carbon::now()->toDateTimeString();

            $matricula = strtoupper($input['MatriculaEstudiante']);

            DB::beginTransaction();

            $idUsuarioDB = DB::table('Usuario')->insertGetId([
                'name'     => $matricula,
                'email'   => 'z' . $matricula . '@estudiantes.uv.mx',
                'password' => $request->password,
                'CreatedAt' => $timestamp,
                'UpdatedAt' => $timestamp,
            ]);

            DB::table('Estudiante')->insert([
                'matriculaEstudiante'   => $matricula,
                'IdUsuario'   => $idUsuarioDB,
            ]);

            DB::table('DatosPersonales')->insert([
                'NombreDatosPersonales'               => $input['NombreDatosPersonales'],
                'ApellidoPaternoDatosPersonales'      => $input['ApellidoPaternoDatosPersonales'],
                'ApellidoMaternoDatosPersonales'      => $input['ApellidoMaternoDatosPersonales'],
                'Genero'                              => $input['Genero'],
                'IdUsuario'   => $idUsuarioDB,
            ]);

            DB::commit();
        } 
        catch (\Throwable $th) {
            DB::rollBack();
            Session::flash('flash', [['type' => "danger", 'message' => "El estudiante NO pudo ser registrado."]]);
            return redirect()->route('estudiantes.index');
        }

        Session::flash('flash', [['type' => "success", 'message' => "Estudiante registrado correctamente."]]);
        return redirect()->route('estudiantes.index');
    }


    public function update(EstudianteRequest $request, Estudiante $estudiante)
    {
        Gate::authorize('havepermiso', 'estudiante-editar-propio');

        $request->validated();

        $estudiante->update([
            'MatriculaEstudiante' => strtoupper($request->MatriculaEstudiante),
        ]);

        $estudiante->update($request->except('MatriculaEstudiante'));
        $estudiante->usuario->datosPersonales->update($request->all());
        $estudiante->usuario->update($request->all());
        
       // $estudiante->trayectoria->update($request->all());
        

        return redirect()->route('estudiantes.index');
    }

    public function destroy(Estudiante $estudiante)
    {
        Gate::authorize('havepermiso', 'estudiante-eliminar-propio');

        try {
            $estudiante->delete();
            // $estudiante->trayectoria->delete();
            $estudiante->usuario->delete();

            Session::flash('flash', [ ['type' => "success", 'message' => "Estudiante eliminado correctamente."] ]);
            return redirect()->route('estudiantes.index');
        } 
        catch (\Throwable $th) {
            Session::flash('flash', [['type' => "danger", 'message' => "El estudiante NO pudo ser eliminado."]]);
            return redirect()->route('estudiantes.index');
        }
    }

    
}
