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

        $fechaInicio = \DateTime::createFromFormat('d/m/Y g:m A', $input['fechaInicio'].' '.$input['horaInicio'] );

        $fechaFin = \DateTime::createFromFormat('d/m/Y g:m A', $input['fechaInicio'].' '.$input['horaFin'] );

        //!!!! Validar que la fechaFin debe ser mayor a la fechaInicio

        //!!! Validar que las fechas no chocan con otro evento

        DB::beginTransaction();

        $idFechaEvento = DB::table('FechaEvento')->insertGetId([
            'InicioFechaEvento' => $fechaInicio,
            'FinFechaEvento'    => $fechaFin,
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
        $fechaInicio = \DateTime::createFromFormat('d/m/Y g:m A', $input['fechaInicio'].' '.$input['horaInicio'] );

        $fechaFin = \DateTime::createFromFormat('d/m/Y g:m A', $input['fechaInicio'].' '.$input['horaFin'] );

        //!!!! Validar que la fechaFin debe ser mayor a la fechaInicio

        //!!! Validar que las fechas no chocan con otro evento

        $fechaEvento = FechaEvento::find( $input['fechaEvento'] );

        if( intval( $input['evento'] ) != $fechaEvento->evento->IdEvento ) {
            $this->addFlash('danger', 'No fue posible realizar la operación solicitada.');
            return redirect()
                ->back()
                ->withErrors($validator)
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
