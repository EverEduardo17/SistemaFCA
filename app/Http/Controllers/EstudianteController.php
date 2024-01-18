<?php

namespace App\Http\Controllers;

use App\Models\Cohorte;
use App\Models\DatosPersonales;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Http\Requests\EstudianteRequest;
use App\Models\Modalidad;
use App\Models\ProgramaEducativo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

/**
 * Controlador para la gestión de estudiantes.
 */
class EstudianteController extends Controller
{
    /**
     * Muestra la lista de todos los estudiantes.
     *
     * @return \Illuminate\View\View La vista que muestra la lista de estudiantes.
     * @throws \Illuminate\Auth\Access\AuthorizationException Si el usuario no tiene el permiso requerido.
     */
    public function index() 
    {
        \Gate::authorize('havepermiso', 'estudiantes-listar');

        $estudiantes = Estudiante::all();

        return view('estudiantes.index')->with('estudiantes', $estudiantes);
    }

    /**
     * Muestra el formulario para crear un nuevo estudiante.
     *
     * @return \Illuminate\View\View La vista del formulario de creación de estudiantes.
     * @throws \Illuminate\Auth\Access\AuthorizationException Si el usuario no tiene el permiso requerido.
     */
    public function create() 
    {
        Gate::authorize('havepermiso', 'estudiantes-crear');

        $cohortes = Cohorte::orderBy('NombreCohorte', 'desc')->get();
        //$grupos = Grupo::orderBy('NombreGrupo', 'asc')->get();
        $modalidades = Modalidad::orderBy('NombreModalidad', 'asc')->get();
        $programasEducativos = ProgramaEducativo::orderBy('NombreProgramaEducativo', 'asc')->get();
        //$grupos = Grupo::orderBy('NombreGrupo', 'asc')->get();

        //return view('estudiantes.create', compact('cohortes', 'grupos', 'modalidades', 'programasEducativos'));
        return view('estudiantes.create', compact('cohortes', 'modalidades', 'programasEducativos'));
    }

    /**
     * Muestra los detalles de un estudiante específico.
     *
     * @param Estudiante $estudiante El estudiante a mostrar.
     * @return \Illuminate\View\View La vista que muestra los detalles del estudiante.
     */
    public function show(Estudiante $estudiante)
    {
        // los estudiantes pueden ver sus propios datos
        $isEstudiante = \Auth::user()->estudiante->IdEstudiante ?? false;
        if ($isEstudiante) {
            if (\Auth::user()->estudiante->IdEstudiante === $estudiante->IdEstudiante) {
                return view('estudiantes.show', compact('estudiante'));   
            }
        }
        Gate::authorize('havepermiso', 'estudiantes-detalles');

        return view('estudiantes.show', compact('estudiante'));   
    }

    /**
     * Muestra el formulario de edición para un estudiante específico.
     *
     * @param Estudiante $estudiante El estudiante a editar.
     * @return \Illuminate\View\View La vista de edición de estudiantes.
     * @throws \Illuminate\Auth\Access\AuthorizationException Si el usuario no tiene el permiso requerido.
     */
    public function edit(Estudiante $estudiante) 
    {
        Gate::authorize('havepermiso', 'estudiantes-crear');

        $cohortes = Cohorte::orderBy('NombreCohorte', 'desc')->get();
        $programasEducativos = ProgramaEducativo::orderBy('NombreProgramaEducativo', 'asc')->get();
        $modalidades = Modalidad::orderBy('NombreModalidad', 'asc')->get();
        $grupos = Grupo::orderBy('NombreGrupo', 'asc')->get();

        return view('estudiantes.edit', compact('estudiante', 'cohortes', 'programasEducativos', 'modalidades', 'grupos'));
    }

    /**
     * Almacena un nuevo estudiante en el sistema.
     *
     * @param EstudianteRequest $request El objeto Request que contiene los datos del estudiante a almacenar.
     * @return \Illuminate\Http\RedirectResponse Una redirección a la página de índice de estudiantes.
     */
    public function store(EstudianteRequest $request)
    {
        Gate::authorize('havepermiso', 'estudiantes-crear');
     
        try {
            $input = $request->validated();
            $timestamp = Carbon::now()->toDateTimeString();

            $matricula = strtoupper($input['MatriculaEstudiante']);

            DB::beginTransaction();

            $idUsuarioDB = DB::table('Usuario')->insertGetId([
                'name'     => "z$matricula",
                'email'   => 'z' . $matricula . '@estudiantes.uv.mx',
                'password' => $request->ProgramaEducativo,
                'CreatedAt' => $timestamp,
                'UpdatedAt' => $timestamp,
                'CreatedBy'     => auth()->user()->IdUsuario,
                'UpdatedBy'     => auth()->user()->IdUsuario
            ]);

            DB::table('Estudiante')->insert([
                'matriculaEstudiante'   => $matricula,
                'IdUsuario'   => $idUsuarioDB,
                'CreatedBy'     => auth()->user()->IdUsuario,
                'UpdatedBy'     => auth()->user()->IdUsuario
            ]);

            DB::table('DatosPersonales')->insert([
                'NombreDatosPersonales'               => $input['NombreDatosPersonales'],
                'ApellidoPaternoDatosPersonales'      => $input['ApellidoPaternoDatosPersonales'],
                'ApellidoMaternoDatosPersonales'      => $input['ApellidoMaternoDatosPersonales'],
                'Genero'                              => $input['Genero'],
                'IdUsuario'   => $idUsuarioDB,
                'CreatedBy'     => auth()->user()->IdUsuario,
                'UpdatedBy'     => auth()->user()->IdUsuario
            ]);

            DB::table('Role_Usuario')->insert([
                    'IdUsuario'     => $idUsuarioDB,
                    'IdRole'        => 3,
                    'CreatedBy'     => auth()->user()->IdUsuario,
                    'UpdatedBy'     => auth()->user()->IdUsuario
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

    /**
     * Actualiza los datos de un estudiante específico.
     *
     * @param EstudianteRequest $request El objeto Request que contiene los datos actualizados del estudiante.
     * @param Estudiante $estudiante El estudiante a actualizar.
     * @return \Illuminate\Http\RedirectResponse Una redirección a la página de índice de estudiantes.
     */
    public function update(EstudianteRequest $request, Estudiante $estudiante)
    {
        Gate::authorize('havepermiso', 'estudiantes-crear');

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

    /**
     * Elimina un estudiante del sistema.
     *
     * @param Estudiante $estudiante El estudiante a eliminar.
     * @return \Illuminate\Http\RedirectResponse Una redirección a la página de índice de estudiantes.
     * @throws \Illuminate\Auth\Access\AuthorizationException Si el usuario no tiene el permiso requerido.
     */
    public function destroy(Estudiante $estudiante)
    {
        Gate::authorize('havepermiso', 'estudiantes-eliminar');

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
