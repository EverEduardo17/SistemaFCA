<?php

namespace App\Http\Controllers;

use App\Models\Evento_Fecha_Sede;
use App\Models\SedeEvento;
use App\Http\Requests\SedeEventoRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class SedeEventoController extends Controller {
    /**
     * Muestra la lista de sedes de eventos.
     *
     * @return \Illuminate\View\View La vista de la lista de sedes de eventos
     * @throws \Illuminate\Auth\Access\AuthorizationException Si el usuario no tiene el permiso requerido.
     */
    public function index() {
        Gate::authorize('havepermiso', 'sedes-listar');

        return view('sedeEvento.index', [
            'sedes' => SedeEvento::get()
        ]);
    }

    /**
     * Muestra el formulario para crear una nueva sede de evento.
     *
     * @return \Illuminate\View\View Vista del formulario de creación de sede.
     * @throws \Illuminate\Auth\Access\AuthorizationException Si el usuario no tiene el permiso requerido.
     */
    public function create() {
        Gate::authorize('havepermiso', 'sedes-listar');

        return view('sedeEvento.create', [
            'sedes' => new SedeEvento()
        ]);
    }

    /**
     * Almacena una nueva sede de evento en la base de datos.
     *
     * @param SedeEventoRequest $request El objeto Request que contiene los datos de la sede de evento a almacenar.
     * @return \Illuminate\Http\RedirectResponse Una redirección a la página de índice de sedes de eventos.
     * @throws \Illuminate\Auth\Access\AuthorizationException Si el usuario no tiene el permiso requerido.
     */
    public function store(SedeEventoRequest $request) {
        Gate::authorize('havepermiso', 'sedes-crear');

        if (DB::table('SedeEvento')->where([['NombreSedeEvento', $request->NombreSedeEvento]])->doesntExist()) {
            // dd($request->validated());
            SedeEvento::create($request->validated());
            Session::flash('flash', [['type' => "success", 'message' => "Sede agregada correctamente."]]);
            return redirect()->route('sedeEventos.index');
        } else {
            Session::flash('flash', [['type' => "danger", 'message' => "La sede ya se encuentra registrada."]]);
            return redirect()->route('sedeEventos.index');
        }
    }
    
    /**
     * Muestra una sede de evento específica.
     *
     * @param SedeEvento $sedeEvento La sede de evento a mostrar.
     * @return void
     */
    public function show(SedeEvento $sedeEvento) {
        //No se implementa en esta función.
    }

    /**
     * Muestra el formulario de edición para una sede de evento existente.
     *
     * @param SedeEvento $sedeEvento La sede de evento a editar.
     * @return \Illuminate\View\View Vista de edición de sede.
     * @throws \Illuminate\Auth\Access\AuthorizationException Si el usuario no tiene el permiso requerido.
     */
    public function edit(SedeEvento $sedeEvento) {
        Gate::authorize('havepermiso', 'sedes-listar');

        return view('sedeEvento.edit', [
            'sede' => $sedeEvento
        ]);
    }

    /**
     * Actualiza los datos de una sede de evento existente.
     *
     * @param SedeEventoRequest $request El objeto Request que contiene los datos actualizados de la sede de evento.
     * @param SedeEvento $sedeEvento La sede de evento a actualizar.
     * @return \Illuminate\Http\RedirectResponse Una redirección a la página de índice de sedes de eventos.
     * @throws \Illuminate\Auth\Access\AuthorizationException Si el usuario no tiene el permiso requerido.
     */
    public function update(SedeEventoRequest $request, SedeEvento $sedeEvento) {
        Gate::authorize('havepermiso', 'sedes-editar');

        try {
            $sedeEvento->update( $request->validated() );
            Session::flash('flash', [['type' => "success", 'message' => "Sede editada correctamente."]]);
            return redirect()->route('sedeEventos.index');
        }catch (\Throwable $throwable){
            Session::flash('flash', [['type' => "danger", 'message' => "Error al editar la sede correctamente."]]);
            return redirect()->route('sedeEventos.index');
        }

    }

    /**
     * Elimina una sede de evento del sistema, si no está asignada a ningún evento.
     *
     * @param SedeEvento $sedeEvento La sede de evento a eliminar.
     * @return \Illuminate\Http\RedirectResponse Una redirección a la página de índice de sedes de eventos.
     * @throws \Illuminate\Auth\Access\AuthorizationException Si el usuario no tiene el permiso requerido.
     */
    public function destroy(SedeEvento $sedeEvento) {
        Gate::authorize('havepermiso', 'sedes-eliminar');

        try {
            $sedeOcupada = Evento_Fecha_Sede::where('IdSedeEvento', $sedeEvento->IdSedeEvento)->count();
            if($sedeOcupada > 0){
                Session::flash('flash', [['type' => "danger", 'message' => "Esta Sede fue asignada a un evento, no puede ser eliminada."]]);
                return redirect()->route('sedeEventos.index');
            }
            $sedeEvento->delete();
            Session::flash('flash', [['type' => "success", 'message' => "Sede eliminada correctamente."]]);
            return redirect()->route('sedeEventos.index');
        }catch (\Throwable $throwable){
            Session::flash('flash', [['type' => "danger", 'message' => "Error al eliminar la sede correctamente."]]);
            return redirect()->route('sedeEventos.index');
        }
    }
}
