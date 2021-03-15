<?php

namespace App\Http\Controllers;

use App\Http\Requests\FechaEventoRequest;
use App\Models\Evento;
use App\Models\Evento_Fecha_Sede;
use App\Models\FechaEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class FechaEventoController extends Controller {
    private $user;
    private $idUsuario;

    public function __construct() {
        $this->user = Auth::user();
        $this->idUsuario = Auth::id();
    }

    public function index() {
        //
    }

    public function create() {
        //
    }

    public function store(FechaEventoRequest $request) {
        Gate::authorize('havepermiso', 'fechaevento-crear');

        $input = $request->validated();

        $idEvento = Evento::findOrFail($input['evento']);
        $idEvento = $idEvento->IdEvento;

        /* Obtener fechas */
        $fechaInicio    = formatearDateTime($input['fechaInicio'], $input['horaInicio']);
        $fechaFin       = formatearDateTime($input['fechaInicio'], $input['horaFin']);

        //!!!! Validar que la fechaFin debe ser mayor a la fechaInicio
        if( formatearTime($input['horaInicio']) >= formatearTime($input['horaFin']) ) {
            Session::flash('flash', [ ['type' => "danger", 'message' => "La Hora Fin, debe ser mayor que la hora Inicio."] ]);
            return redirect()->route('eventos.create')->withInput();
        }

        //!!! Validar que las fechas no chocan con otro evento
        try {
            DB::beginTransaction();
                $idFechaEvento = DB::table('FechaEvento')->insertGetId([
                    'InicioFechaEvento' => $fechaInicio,
                    'FinFechaEvento'    => $fechaFin,
                    'CreatedBy'         => $this->idUsuario,
                    'UpdatedBy'         => $this->idUsuario,
                ]);

                DB::table('Evento_Fecha_Sede')->insert([
                    'IdEvento'      => $idEvento,
                    'IdFechaEvento' => $idFechaEvento,
                    'IdSedeEvento'  => intval( $input['sede'] ),
                    'CreatedBy'     => $this->idUsuario,
                    'UpdatedBy'     => $this->idUsuario,
                ]);
            DB::commit();
        }catch (\Throwable $e) {
            DB::rollBack();
            Session::flash('flash', [ ['type' => "danger", 'message' => "No fue posible realizar la operación solicitada."] ]);
            return redirect()->back()->withInput();
        }

        Session::flash('flash', [ ['type' => "success", 'message' => "Fecha agregada con éxito."] ]);
        return redirect()->back();
    }

    public function show(FechaEvento $fechaEvento){
        //
    }

    public function edit(FechaEvento $fechaEvento){
        //
    }

    public function update(FechaEventoRequest $request) {
        Gate::authorize('havepermiso', 'fechaevento-editar');

        $input = $request->validated();

        /* Obtener fechas */
        $fechaInicio    = formatearDateTime($input['fechaInicio'], $input['horaInicio']);
        $fechaFin       = formatearDateTime($input['fechaInicio'], $input['horaFin']);

        //!!!! Validar que la fechaFin debe ser mayor a la fechaInicio
        if( formatearTime($input['horaInicio']) >= formatearTime($input['horaFin']) ) {
            Session::flash('flash', [ ['type' => "danger", 'message' => "La Hora Fin, debe ser mayor que la hora Inicio."] ]);
            return redirect()->route('eventos.create')->withInput();
        }

        //!!! Validar que las fechas no chocan con otro evento

        $fechaEvento = FechaEvento::find( $input['fechaEvento'] );

        if( intval( $input['evento'] ) != $fechaEvento->evento->IdEvento ) {
            Session::flash('flash', [ ['type' => "danger", 'message' => "No fue posible realizar la operación solicitada."] ]);
            return redirect()
                ->back()
                ->withInput();
        }

        try{

            DB::beginTransaction();

            $fechaEvento = FechaEvento::find( $input['fechaEvento'] );
            $fechaEvento->InicioFechaEvento = $fechaInicio;
            $fechaEvento->FinFechaEvento = $fechaFin;
            $fechaEvento->UpdatedBy = $this->idUsuario;
            $fechaEvento->save();

            $evento_fecha_sede = $fechaEvento->evento_fecha_sede;
            $evento_fecha_sede->IdSedeEvento = $input['sede'];
            $evento_fecha_sede->UpdatedBy = $this->idUsuario;
            $evento_fecha_sede->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            Session::flash('flash', [ ['type' => "danger", 'message' => "No fue posible realizar la operación solicitada."] ]);
            return redirect()
                ->back()
                ->withInput();
        }

        Session::flash('flash', [ ['type' => "success", 'message' => "Fecha actualizada con éxito."] ]);
        return redirect()->back();
    }

    public function destroy(Request $request) {
        Gate::authorize('havepermiso', 'fechaevento-eliminar');

        $input = $request->all();
        $rules = [
            'fechaEvento' => 'required|exists:App\Models\FechaEvento,IdFechaEvento|exists:App\Models\Evento_Fecha_Sede,IdFechaEvento'
        ];
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            Session::flash('flash', [ ['type' => "danger", 'message' => "No fue posible realizar la operación solicitada."] ]);
            return redirect()->back();
        }

        $fecha_sede_evento_s = Evento_Fecha_Sede::where('IdFechaEvento',$input['fechaEvento'])->first();
        $fechaEvento = $fecha_sede_evento_s->fechaEvento;
        if( $fecha_sede_evento_s->delete() ){
            $fechaEvento->delete();
            Session::flash('flash', [ ['type' => "success", 'message' => "Fecha <strong>eliminada</strong> con éxito."] ]);
            return redirect()->back();
        }

        Session::flash('flash', [ ['type' => "danger", 'message' => "No fue posible realizar la operación solicitada."] ]);
        return redirect()->back();
    }
}
