<?php

namespace App\Http\Controllers;

use App\Academico;
use App\Http\Requests\EventoRequest;
use App\Evento;
use App\Evento_Fecha_Sede;
use App\SedeEvento;
use App\Documento;
use App\Organizador;
use App\TipoOrganizador;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Extensions\MongoSessionStore;
use Illuminate\Support\Facades\Session;

class EventoController extends FcaController
{
    private $user;
    private $idUsuario;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function index()
    {
        $evento_fecha_sede_s = Evento_Fecha_Sede
            ::with(['evento', 'fechaEvento', 'sedeEvento'])
            ->get()
            ->where('fechaEvento.InicioFechaEvento','>=', (new \DateTime())->format("Y-m-d") )
            ->sortBy('fechaEvento.InicioFechaEvento');
        //dd($evento_fecha_sede_s->sortBy('FechaInicioEvento'));
        return view('eventos.index', [
            "evento_fecha_sede_s" => $evento_fecha_sede_s
        ]);
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
        return view('eventos.index', [
            "evento_fecha_sede_s" => $evento_fecha_sede_s
        ]);
    }

    public function create()
    {
        return view('eventos.create', [
            "sedes" => SedeEvento::all()
        ]);
    }

    public function store(EventoRequest $request)
    {
        $input = $request->validated();
        //dd($input);

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
            return redirect()->route('eventos.create')
                ->withInput();
        }

        //!!! Validar que las fechas no chocan con otro evento
        //dd($this->user);
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

            if( $idOrganizador == null || $idOrganizador == 0 || $idSedeEvento == null || $idSedeEvento == 0 ){
                DB::rollBack();
                Session::flash('flash', [ ['type' => "danger", 'message' => "Error al registrar el evento."] ]);
                return redirect()->route('eventos.index');
            }

        DB::commit();

        //$validator = Validator::make($input, $rules, $messages);
        Session::flash('flash', [ ['type' => "success", 'message' => "Evento registrado correctamente"] ]);
        return redirect()->route('eventos.index');
    }

    public function show(Evento $evento)
    {
        $evento_fecha_sede_s = Evento_Fecha_Sede::where('IdEvento', $evento->IdEvento)
            ->with(['fechaEvento', 'sedeEvento'])
            ->get()
            ->sortBy('fechaEvento.InicioFechaEvento');
        $documentos = Documento::where('IdEvento', $evento->IdEvento)->get();
        $data = Organizador::select('IdAcademico')->where('IdEvento', $evento->IdEvento)->get()->toArray();
        $acemicosNot = Academico::whereNotIn('IdAcademico', $data)->get();
        return view('eventos.show', [
            "evento"=>$evento,
            "evento_fecha_sede_s"=>$evento_fecha_sede_s,
            "sedes" =>SedeEvento::all(),
            "documentos" => $documentos,
            "responsables" => Organizador::where('IdEvento', $evento->IdEvento)->get(),
            "tipoorganizadores" => TipoOrganizador::get(),
            "academicos"    => $acemicosNot
        ]);
    }
    public function edit(Evento $evento)
    {
        //
    }

    public function update(Request $request, $evento)
    {
        $evento = Evento::findOrFail( $evento );
        $request->validate([
            'NombreEvento'       => 'required | String',
            'DescripcionEvento'  => 'required | String',
        ]);

        try {
            DB::beginTransaction();
                DB::table('evento')->where('IdEvento', $evento->IdEvento)->update([
                    'NombreEvento'       => $request->NombreEvento,
                    'DescripcionEvento'  => $request->DescripcionEvento,
                ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Session::flash('flash', [ ['type' => "danger", 'message' => "Error al editar el Evento."] ]);
            return redirect()->route('eventos.show', $evento->IdEvento);
        }
        Session::flash('flash', [ ['type' => "success", 'message' => "Evento editado con exito."] ]);
        return redirect()->route('eventos.show', $evento->IdEvento);
    }

    public function destroy(Evento $evento)
    {
        //
    }
}
