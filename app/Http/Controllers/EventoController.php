<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditarEventoRequest;
use App\Models\Academico;
use App\Models\AcademicoEvento;
use App\Http\Requests\EventoRequest;
use App\Models\Evento;
use App\Models\Evento_Fecha_Sede;
use App\Mail\EventoRegistrado;
use App\Models\FechaEvento;
use App\Models\Role;
use App\Models\SedeEvento;
use App\Models\Organizador;
use App\Models\TipoOrganizador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class EventoController extends Controller
{
    private $user;
    private $idUsuario;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->idUsuario = Auth::id();
    }

    public function index()
    {
        $estado = request('estado');
        Gate::authorize('havepermiso', 'eventos-listar');
        if($estado != null){
            $evento_fecha_sede_s = Evento_Fecha_Sede
            ::with(['evento', 'fechaEvento', 'sedeEvento'])
            ->get()
            ->where('evento.EstadoEvento','==', $estado)
            ->sortBy('fechaEvento.InicioFechaEvento');
        }else{
            $evento_fecha_sede_s = Evento_Fecha_Sede
            ::with(['evento', 'fechaEvento', 'sedeEvento'])
            ->get()
            //->where('evento.EstadoEvento','==', $estado)
            ->sortBy('fechaEvento.InicioFechaEvento');
        }
        

        /**
         * Es una variable distinta, para no afectar el funcionamiento de la vista original mientras
         * se decide que hacer con ella. Full Calendar debe recibir un array de los eventos en json
         * con los siguientes atributos.
         */

         $color = [
            "APROBADO" => "green",
            "NO APROBADO" => "red",
            "POR APROBAR" => "yellow"
        ];



        $calendar_events = [];
        foreach ($evento_fecha_sede_s as $efs) {
            $calendar_events[] = [
                "id" => $efs->evento->IdEvento,
                "title" => $efs->evento->NombreEvento . " - " . $efs->sedeEvento->NombreSedeEvento,
                "start" => $efs->fechaEvento->InicioFechaEvento,
                "end" => $efs->fechaEvento->FinFechaEvento,
                "url" => route('eventos.show', [$efs->evento->IdEvento]),
                "backgroundColor" => $color[$efs->evento->EstadoEvento],
            ];
        }

        return view('eventos.index', [
            "evento_fecha_sede_s" => $evento_fecha_sede_s,
            "calendar_events" => $calendar_events,
            "estado" => $estado
        ]);
    }

    public function indexWithDate($year, $month, $day)
    {
        Gate::authorize('havepermiso', 'eventos-listar');

        $estado = request('estado');

        $date = sprintf("%d-%02d-%02d", $year, $month, $day);
        $from = date("Y-m-d", strtotime($date));
        $to = date("Y-m-d", strtotime($date . " +1 days"));

        $evento_fecha_sede_s = Evento_Fecha_Sede::with(['evento', 'fechaEvento', 'sedeEvento'])
            ->get()
            ->where('fechaEvento.InicioFechaEvento', '>=', $from)
            ->where('fechaEvento.InicioFechaEvento', '<', $to)
            ->sortBy('fechaEvento.InicioFechaEvento',  false);

        /**
         * Si se mantiene esta funcionalidad, habra que valorar pasar la fecha como una
         * variable para que el calendario se abra en la fecha elegida al iniciar.
         */
        $color = [
            "APROBADO" => "green",
            "NO APROBADO" => "red",
            "POR APROBAR" => "yellow"
        ];

        $calendar_events = [];
        foreach ($evento_fecha_sede_s as $efs) {
            $calendar_events[] = [
                "id" => $efs->evento->IdEvento,
                "title" => $efs->evento->NombreEvento . " - " . $efs->sedeEvento->NombreSedeEvento,
                "start" => $efs->fechaEvento->InicioFechaEvento,
                "end" => $efs->fechaEvento->FinFechaEvento,
                "url" => route('eventos.show', [$efs->evento->IdEvento]),
                "backgroundColor" => $color[$efs->evento->EstadoEvento],
            ];
        }

        return view('eventos.index', [
            "evento_fecha_sede_s" => $evento_fecha_sede_s,
            "calendar_events" => $calendar_events,
            "estado" => $estado
        ]);
    }

    public function create()
    {
        Gate::authorize('havepermiso', 'eventos-listar');

        $date = null;

        if (request()->has("day") && request()->has("month") && request()->has("year")) {
            $day = request("day");
            $month = request("month");
            $year = request("year");

            $date = "$day/$month/$year";
        }

        return view('eventos.create', [
            "sedes" => SedeEvento::all(),
            "date" => $date
        ]);
    }

    public function store(EventoRequest $request)
    {
        Gate::authorize('havepermiso', 'eventos-crear');

        $input = $request->validated();

        $fechaInicio    = formatearDateTime($input['fechaInicio'], $input['horaInicio']);
        $fechaFin       = formatearDateTime($input['fechaInicio'], $input['horaFin']);

        if (formatearTime($input['horaInicio']) >= formatearTime($input['horaFin'])) {
            Session::flash('flash', [['type' => "danger", 'message' => "La Hora Fin, debe ser mayor que la hora Inicio."]]);

            return redirect()->route('eventos.create')
                             ->withInput();
        }

        // dd(Auth::user()->Academico->IdAcademico);

        //TODO: Validar que las fechas no chocan con otro evento
        $comprobarFecha = $this->comprobarFecha($fechaInicio, $fechaFin, intval($input['sede']));
        if (!$comprobarFecha) {
            try {
                DB::beginTransaction();
                $idEvento = DB::table('Evento')->insertGetId([
                    'NombreEvento'      => $input['nombre'],
                    'DescripcionEvento' => $input['descripcion'],
                    'EstadoEvento'      => 'POR APROBAR',
                    'CreatedBy'         => Auth::user()->IdUsuario,
                    'UpdatedBy'         => Auth::user()->IdUsuario
                ]);

                DB::table('Organizador')->insert([
                    'IdEvento'           => $idEvento,
                    'IdAcademico'        => Auth::user()->Academico->IdAcademico,
                    'IdTipoOrganizador'  => 1,
                    'CreatedBy'          => Auth::user()->IdUsuario,
                    'UpdatedBy'          => Auth::user()->IdUsuario
                ]);

                $idFechaEvento = DB::table('FechaEvento')->insertGetId([
                    'InicioFechaEvento' => $fechaInicio,
                    'FinFechaEvento'    => $fechaFin,
                    'CreatedBy'         => Auth::user()->IdUsuario,
                    'UpdatedBy'         => Auth::user()->IdUsuario
                ]);

                DB::table('Evento_Fecha_Sede')->insert([
                    'IdEvento'      => $idEvento,
                    'IdFechaEvento' => $idFechaEvento,
                    'IdSedeEvento'  => intval($input['sede']),
                    'CreatedBy'     => Auth::user()->IdUsuario,
                    'UpdatedBy'     => Auth::user()->IdUsuario
                ]);
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                Session::flash('flash', [['type' => "danger", 'message' => "Error al registrar el evento."]]);
                // Session::flash('flash', [['type' => "danger", 'message' => $e->getMessage()]]);
                return redirect()->route('eventos.index');
            }

            //EnviarCorreos
            $users = Role::where('IdRole', 3)->first();
            foreach ($users->usuarios as $user) {
                Mail::to($user->email)->send(new EventoRegistrado($input));
            }

            Session::flash('flash', [['type' => "success", 'message' => "Evento registrado correctamente"]]);
            return redirect()->route('eventos.show', $idEvento);
        } else {
            Session::flash('flash', [['type' => "danger", 'message' => "Error al registrar el evento, el evento " . $comprobarFecha->NombreEvento . " ya se encuentra registrado en ese horario."]]);
            return redirect()->route('eventos.index');
        }
    }

    public function show($idEvento)
    {
        Gate::authorize('havepermiso', 'eventos-leer');

        $evento = Evento::where('IdEvento', $idEvento)->with(['eventoFechaSede', 'organizador', 'documento', 'eventoFechaSede.fechaEvento', 'eventoFechaSede.sedeEvento'])->firstOrFail();

        $data = Organizador::select('IdAcademico')->where('IdEvento', $evento->IdEvento)->get()->toArray();
        $acemicosNot = Academico::whereNotIn('IdAcademico', $data)->get();
        $data = AcademicoEvento::select('IdAcademico')->where('IdEvento', $evento->IdEvento)->get()->toArray();
        $participanteNot = Academico::whereNotIn('IdAcademico', $data)->get();

        return view('eventos.show', [
            "evento"                => $evento,
            "evento_fecha_sede_s"   => $evento->eventoFechaSede,
            "sedes"                 => SedeEvento::all(),
            "tipoorganizadores"     => TipoOrganizador::get(),
            "academicos"            => $acemicosNot,
            'participantes'         => $participanteNot
        ]);
    }

    public function update(EditarEventoRequest $request, $evento)
    {
        Gate::authorize('havepermiso', 'eventos-editar');

        $evento = Evento::findOrFail($evento);
        $request->validated();

        try {
            DB::beginTransaction();
            DB::table('Evento')->where('IdEvento', $evento->IdEvento)->update([
                'NombreEvento'       => $request->NombreEvento,
                'DescripcionEvento'  => $request->DescripcionEvento,
                'UpdatedBy'         => $this->idUsuario,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Session::flash('flash', [['type' => "danger", 'message' => "Error al editar el Evento."]]);
            return redirect()->route('eventos.show', $evento->IdEvento);
        }
        Session::flash('flash', [['type' => "success", 'message' => "Evento actualizado con éxito."]]);
        return redirect()->route('eventos.show', $evento->IdEvento);
    }

    public function destroy(Evento $evento)
    {
        Gate::authorize('havepermiso', 'eventos-eliminar');
    }


    private function comprobarFecha($fechaInicio, $fechaFin, $sedeEvento)
    {
        //TODO: Comprobar que no sea el primer evento el que tome.
        $fechaInicioOcupada = FechaEvento::whereBetween('InicioFechaEvento', array($fechaInicio, $fechaFin))->get();
        $fechaFinOcupada    = FechaEvento::whereBetween('FinFechaEvento', array($fechaInicio, $fechaFin))->get();
        $eventoAprobado     = false;
        foreach ($fechaInicioOcupada as $fechaInicio) {
            if ($fechaInicio->evento->EstadoEvento == "Aprobado") {
                $eventoAprobado = true;
            }
        }
        foreach ($fechaFinOcupada as $fechaFin) {
            if ($fechaFin->evento->EstadoEvento == "Aprobado") {
                $eventoAprobado = true;
            }
        }
        if ($fechaInicioOcupada->count() > 0 || $fechaFinOcupada->count() > 0 || $eventoAprobado) {
            $fechaEvento    = FechaEvento::whereBetween('InicioFechaEvento', array($fechaInicio, $fechaFin))->orderBy('IdFechaEvento', 'desc')->first();
            if ($fechaEvento != null && $sedeEvento == $fechaEvento->evento_fecha_sede->sedeEvento->IdSedeEvento) {
                return $fechaEvento->evento_fecha_sede->evento;
            } else {
                $fechaEvento = FechaEvento::whereBetween('FinFechaEvento', array($fechaInicio, $fechaFin))->orderBy('IdFechaEvento', 'desc')->first();
                if ($fechaEvento != null && $sedeEvento == $fechaEvento->evento_fecha_sede->sedeEvento->IdSedeEvento) {
                    return $fechaEvento->evento_fecha_sede->evento;
                }
            }
            return false;
        } else {
            return false;
        }
    }
}
