<?php

namespace App\Http\Controllers;

use App\Http\Requests\FechaEventoRequest;
use App\Evento;
use App\Evento_Fecha_Sede;
use App\FechaEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class FechaEventoController extends FcaController
{
    private $user;
    private $idUsuario;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->idUsuario = $this->user->IdUsuario;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(FechaEventoRequest $request)
    {
        $input = $request->validated();

        $idEvento = $input['evento'];

        /* Obtener fechas */
        $fechaInicio = explode( '/', $input['fechaInicio'] );
        $horaInicio  = explode( ' ', $input['horaInicio'] );
        $PM          = strcmp ( 'PM', mb_strtoupper( $horaInicio[1] ) ) == 0;
        $horaInicio  = explode( ':', $horaInicio[0] );
        if( $PM ){
            $horaInicio[0] += 12;
        }

        $fechaFin = $fechaInicio;
        $horaFin  = explode(' ', $input['horaFin'] );
        $PM       = strcmp ( 'PM', mb_strtoupper($horaFin[1]) ) == 0;
        $horaFin  = explode(':', $horaFin[0] );
        if( $PM ){
            $horaFin[0] += 12;
        }

        //!!!! Validar que la fechaFin debe ser mayor a la fechaInicio

        $fechaInicioFormat = sprintf("%d-%d-%d %d:%d",
            $fechaInicio[2], $fechaInicio[1], $fechaInicio[0], $horaInicio[0], $horaInicio[1] );
        $fechaFinFormat = sprintf("%d-%d-%d %d:%d",
            $fechaFin[2], $fechaFin[1], $fechaFin[0], $horaFin[0], $horaFin[1] );
        $hrInicio = sprintf("%d%d",
            $horaInicio[0], $horaInicio[1] );
        $hrFin = sprintf("%d%d",
            $horaFin[0], $horaFin[1] );
        if($hrInicio >= $hrFin){
            Session::flash('flash', [ ['type' => "danger", 'message' => "La Hora Fin, debe ser mayor que la hora Inicio."] ]);
            return redirect()->back()
                ->withInput();
        }

        //!!!! Validar que la fechaFin debe ser mayor a la fechaInicio

        //!!! Validar que las fechas no chocan con otro evento

        DB::beginTransaction();

        $idFechaEvento = DB::table('FechaEvento')->insertGetId([
            'InicioFechaEvento' => $fechaInicioFormat,
            'FinFechaEvento'    => $fechaFinFormat,
            'CreatedBy'         => $this->idUsuario,
            'UpdatedBy'         => $this->idUsuario,
        ]);

        $idSedeEvento = DB::table('Evento_Fecha_Sede')->insertGetId([
            'IdEvento'      => $idEvento,
            'IdFechaEvento' => $idFechaEvento,
            'IdSedeEvento'  => intval( $input['sede'] ),
            'CreatedBy'     => $this->idUsuario,
            'UpdatedBy'     => $this->idUsuario,
        ]);

        if( $idSedeEvento == null || $idSedeEvento == 0 ){
            DB::rollBack();
            $this->addFlash('danger','No fue posible realizar la operación solicitada.');
            return redirect()
                ->back()
                ->withInput()
                ->with('flash',$this->getFlash() );
            //!!! Enviar alerta de error
        }

        DB::commit();

        Session::flash('flash', [ ['type' => "success", 'message' => "Fecha Agregada Con Exito."] ]);
        return redirect()->back();
    }

    public function show(FechaEvento $fechaEvento)
    {
        //
    }

    public function edit(FechaEvento $fechaEvento)
    {
        //
    }

    public function update(FechaEventoRequest $request)
    {
        $input = $request->validated();

        /* Obtener fechas */
        /* Obtener fechas */
        $fechaInicio = explode( '/', $input['fechaInicio'] );
        $horaInicio  = explode( ' ', $input['horaInicio'] );
        $PM          = strcmp ( 'PM', mb_strtoupper( $horaInicio[1] ) ) == 0;
        $horaInicio  = explode( ':', $horaInicio[0] );
        if( $PM ){
            $horaInicio[0] += 12;
        }

        $fechaFin = $fechaInicio;
        $horaFin  = explode(' ', $input['horaFin'] );
        $PM       = strcmp ( 'PM', mb_strtoupper($horaFin[1]) ) == 0;
        $horaFin  = explode(':', $horaFin[0] );
        if( $PM ){
            $horaFin[0] += 12;
        }

        $fechaInicio = sprintf("%d-%d-%d %d:%d",
            $fechaInicio[2], $fechaInicio[1], $fechaInicio[0], $horaInicio[0], $horaInicio[1] );

        $fechaFin = sprintf("%d-%d-%d %d:%d",
            $fechaFin[2], $fechaFin[1], $fechaFin[0], $horaFin[0], $horaFin[1] );

        //!!!! Validar que la fechaFin debe ser mayor a la fechaInicio
        $hrInicio = sprintf("%d%d",
            $horaInicio[0], $horaInicio[1] );
        $hrFin = sprintf("%d%d",
            $horaFin[0], $horaFin[1] );
        if($hrInicio >= $hrFin){
            Session::flash('flash', [ ['type' => "danger", 'message' => "La Hora Fin, debe ser mayor que la hora Inicio."] ]);
            return redirect()->back()
                ->withInput();
        }

        //!!! Validar que las fechas no chocan con otro evento

        $fechaEvento = FechaEvento::find( $input['fechaEvento'] );

        if( intval( $input['evento'] ) != $fechaEvento->evento->IdEvento ) {
            $this->addFlash('danger', 'No fue posible realizar la operación solicitada.');
            return redirect()
                ->back()
                ->withInput()
                ->with($this->getFlash());
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
        } catch (Throwable $e) {
            DB::rollBack();

            $this->addFlash('danger', 'No fue posible realizar la operación solicitada.');
            return redirect()
                ->back()
                ->withInput()
                ->with('flash', $this->getFlash());
            //!!! Enviar alerta de error
        }

        Session::flash('flash', [ ['type' => "success", 'message' => "Fecha Actualizada Con Exito."] ]);
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $input = $request->all();
        $rules = [
            'fechaEvento' => 'required|exists:App\FechaEvento,IdFechaEvento|exists:App\Evento_Fecha_Sede,IdFechaEvento'
        ];

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $this->addFlash('danger', 'No fue posible eliminar la fecha.');
            return redirect()->back()->with('flash',$this->getFlash());
        }

        $fecha_sede_evento_s = Evento_Fecha_Sede::where('IdFechaEvento',$input['fechaEvento'])->first();
        $fechaEvento = $fecha_sede_evento_s->fechaEvento;
        if( $fecha_sede_evento_s->delete() ){
            $fechaEvento->delete();
            $this->addFlash('success', 'Fecha <strong>eliminada</strong> con éxito.');
            return redirect()->back()->with('flash',$this->getFlash());
        }

        $this->addFlash('danger', 'No fue posible eliminar la fecha.');
        return redirect()->back()->with('flash',$this->getFlash());
    }
}
