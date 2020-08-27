<?php

namespace App\Http\Controllers;

use App\Evento;
use App\Evento_Fecha_Sede;
use App\SedeEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class EventoController extends FcaController
{
    private $user;
    private $idUsuario;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evento_fecha_sede_s = Evento_Fecha_Sede
            ::with(['evento', 'fechaEvento', 'sedeEvento'])
            ->get()
            ->where('fechaEvento.InicioFechaEvento','>=', (new \DateTime())->format("Y-m-d") )
            ->sortBy('fechaEvento.InicioFechaEvento');
        //dd($evento_fecha_sede_s->sortBy('FechaInicioEvento'));
        return view('eventos.index', ["evento_fecha_sede_s"=>$evento_fecha_sede_s]);
    }

    public function indexWithDate($year, $month, $day)
    {
        $date = sprintf("%d-%02d-%02d", $year, $month, $day);
        $from = date( "Y-m-d", strtotime( $date ) );
        $to = date( "Y-m-d", strtotime( $date . " +1 days" ) );

        $evento_fecha_sede_s = Evento_Fecha_Sede::with(['evento', 'fechaEvento', 'sedeEvento'])
            ->get()
            ->where('fechaEvento.InicioFechaEvento','>=',$from)
            ->where('fechaEvento.InicioFechaEvento','<',$to)
            ->sortBy('fechaEvento.InicioFechaEvento', 1, false);
        return view('eventos.index', ["evento_fecha_sede_s"=>$evento_fecha_sede_s]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sedes = SedeEvento::all();
        return view('eventos.create', ["sedes"=>$sedes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        //dd($input);
        $rules = [
            'nombre' => 'required|max:100',
            'descripcion' => 'required|max:150',
            'fechaInicio' => 'required|date_format:d/m/Y',
            'horaInicio' => 'required|date_format:g:i A',
            'horaFin' => 'required|date_format:g:i A',
            'sede' => 'required|exists:App\SedeEvento,IdSedeEvento'
        ];
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return redirect()
                ->route('eventos_create')
                ->withErrors($validator)
                ->withInput();
        }

        $messages = [
            'email.required' => 'We need to know your e-mail address!',
        ];

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

        //!!! Validar que las fechas no chocan con otro evento

        DB::beginTransaction();

            $idEvento = DB::table('Evento')->insertGetId([
                'NombreEvento'      => $input['nombre'],
                'DescripcionEvento' => $input['descripcion'],
                'CreatedBy'         => $this->idUsuario,
                'UpdatedBy'         => $this->idUsuario,
            ]);

            $idOrganizador = DB::table('Organizador')->insertGetId([
                'IdEvento'           => $idEvento,
                'IdAcademico'        => $this->user->academico->IdAcademico,
                'IdTipoOrganizador'  => 1,
                'CreatedBy'          => $this->idUsuario,
                'UpdatedBy'          => $this->idUsuario,
            ]);

            $idFechaEvento = DB::table('FechaEvento')->insertGetId([
                'InicioFechaEvento' => sprintf("%d-%d-%d %d:%d",
                                        $fechaInicio[2], $fechaInicio[1], $fechaInicio[0], $horaInicio[0], $horaInicio[1] ),
                'FinFechaEvento'    => sprintf("%d-%d-%d %d:%d",
                                        $fechaFin[2], $fechaFin[1], $fechaFin[0], $horaFin[0], $horaFin[1] ),
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



            if( $idOrganizador == null || $idOrganizador == 0 || $idSedeEvento == null || $idSedeEvento == 0 ){
                DB::rollBack();
                return redirect()
                    ->route('eventos_create')
                    ->withInput();
                //!!! Enviar alerta de error
            }

        DB::commit();
        dd($input);
        //$validator = Validator::make($input, $rules, $messages);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento)
    {
        $evento_fecha_sede_s = Evento_Fecha_Sede
            ::where('IdEvento', $evento->IdEvento)
            ->with(['fechaEvento', 'sedeEvento'])
            ->get()
            ->sortBy('fechaEvento.InicioFechaEvento');
        $sedes = SedeEvento::all();
        return view('eventos.show',
            [
                "evento"=>$evento, "evento_fecha_sede_s"=>$evento_fecha_sede_s,
                "sedes" =>$sedes
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit(Evento $evento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evento $evento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evento $evento)
    {
        //
    }
}
