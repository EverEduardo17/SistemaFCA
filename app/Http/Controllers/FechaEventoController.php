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

class FechaEventoController extends Controller
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
        //
    }

    public function create()
    {
        //
    }

    /**
     * Metodo para agregar nuevas fechas a un evento
     * Desde la vista eventos.show en la parte inferior donde se ven las fechas
     *
     * @param  FechaEventoRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FechaEventoRequest $request)
    {
        Gate::authorize('havepermiso', 'eventos-crear');

        $input = $request->validated();

        $idEvento = Evento::findOrFail($input['evento']);

        $input['nombre'] = $idEvento->NombreEvento;
        $input['descripcion'] = $idEvento->DescripcionEvento;

        $idEvento = $idEvento->IdEvento;

        $input['organizador'] = Auth::user()->email;

        /* Obtener fechas */
        $fechaInicio    = formatearDateTime($input['fechaInicio'], $input['horaInicio']);
        $fechaFin       = formatearDateTime($input['fechaInicio'], $input['horaFin']);

        //!!!! Validar que la fechaFin debe ser mayor a la fechaInicio
        if (formatearTime($input['horaInicio']) >= formatearTime($input['horaFin'])) {
            Session::flash('flash', [['type' => "danger", 'message' => "La Hora Fin, debe ser mayor que la hora Inicio."]]);
            return redirect()->back()->withInput();
        }

        //TODO: Validar que las fechas no chocan con otro evento
        //TODO: Crear un método único en EventoController se duplica.
        $comprobarFecha = $this->comprobarFecha($fechaInicio, $fechaFin, intval($input['sede']));
        if (!$comprobarFecha) {
            try {
                DB::beginTransaction();
                    DB::table('Evento')->where('IdEvento', $idEvento)->update([
                        'EstadoEvento'       => 'POR APROBAR',
                    ]);

                    $idFechaEvento = DB::table('FechaEvento')->insertGetId([
                        'InicioFechaEvento' => $fechaInicio,
                        'FinFechaEvento'    => $fechaFin,
                        'CreatedBy'         => $this->idUsuario,
                        'UpdatedBy'         => $this->idUsuario,
                    ]);

                    DB::table('Evento_Fecha_Sede')->insert([
                        'IdEvento'      => $idEvento,
                        'IdFechaEvento' => $idFechaEvento,
                        'IdSedeEvento'  => intval($input['sede']),
                        'CreatedBy'     => $this->idUsuario,
                        'UpdatedBy'     => $this->idUsuario,
                    ]);
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                Session::flash('flash', [['type' => "danger", 'message' => "No fue posible realizar la operación solicitada."]]);
                return redirect()->back()->withInput();
            }
        } else {
            Session::flash('flash', [['type' => "danger", 'message' => "Error al registrar el evento, el evento " . $comprobarFecha->NombreEvento . " ya se encuentra registrado en ese horario."]]);
            return redirect()->back()->withInput();
        }


        if ( !(Auth::user()->havePermission('eventos-aprobar-rechazar')) ) {
            $this->enviarCorreo($input);
        }

        Session::flash('flash', [['type' => "success", 'message' => "Fecha agregada con éxito."]]);
        return redirect()->back()->withInput();
    }

    public function show(FechaEvento $fechaEvento)
    {
        //
    }

    public function edit(FechaEvento $fechaEvento)
    {
        //
    }

    /**
     * Metodo para editar las fechas agregadas a un evento
     * Desde la vista eventos.show en la parte inferior donde se ven las fechas
     *
     * @param  FechaEventoRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(FechaEventoRequest $request)
    {
        Gate::authorize('havepermiso', 'eventos-editar-propio');

        $input = $request->validated();

        /* Obtener fechas */
        $fechaInicio    = formatearDateTime($input['fechaInicio'], $input['horaInicio']);
        $fechaFin       = formatearDateTime($input['fechaInicio'], $input['horaFin']);

        //!!!! Validar que la fechaFin debe ser mayor a la fechaInicio
        if (formatearTime($input['horaInicio']) >= formatearTime($input['horaFin'])) {
            Session::flash('flash', [['type' => "danger", 'message' => "La Hora Fin, debe ser mayor que la hora Inicio."]]);
            return redirect()->back()->withInput();
        }

        //!!! Validar que las fechas no chocan con otro evento

        $fechaEvento = FechaEvento::find($input['fechaEvento']);

        $input['nombre'] = $fechaEvento->evento->NombreEvento;
        $input['descripcion'] = $fechaEvento->evento->DescripcionEvento;
        $input['organizador'] = Auth::user()->email;
        $input['evento'] = $fechaEvento->evento->IdEvento;

        if (intval($input['evento']) != $fechaEvento->evento->IdEvento) {
            Session::flash('flash', [['type' => "danger", 'message' => "No fue posible realizar la operación solicitada."]]);
            return redirect()
                ->back()
                ->withInput();
        }

        try {

            DB::beginTransaction();

            DB::table('Evento')->where('IdEvento', $fechaEvento->evento->IdEvento)->update([
                'EstadoEvento'       => 'POR APROBAR',
            ]);

            $fechaEvento = FechaEvento::find($input['fechaEvento']);
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

            Session::flash('flash', [['type' => "danger", 'message' => "No fue posible realizar la operación solicitada."]]);
            return redirect()
                ->back()
                ->withInput();
        }

        if ( !(Auth::user()->havePermission('eventos-aprobar-rechazar')) ) {
            $this->enviarCorreo($input);
        }

        Session::flash('flash', [['type' => "success", 'message' => "Fecha actualizada con éxito."]]);
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        Gate::authorize('havepermiso', 'eventos-eliminar-propio');

        $input = $request->all();
        $rules = [
            'fechaEvento' => 'required|exists:App\Models\FechaEvento,IdFechaEvento|exists:App\Models\Evento_Fecha_Sede,IdFechaEvento'
        ];
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            Session::flash('flash', [['type' => "danger", 'message' => "No fue posible realizar la operación solicitada."]]);
            return redirect()->back();
        }

        $fecha_sede_evento_s = Evento_Fecha_Sede::where('IdFechaEvento', $input['fechaEvento'])->first();
        $fechaEvento = $fecha_sede_evento_s->fechaEvento;
        if ($fecha_sede_evento_s->delete()) {
            $fechaEvento->delete();
            Session::flash('flash', [['type' => "success", 'message' => "Fecha <strong>eliminada</strong> con éxito."]]);
            return redirect()->back();
        }

        Session::flash('flash', [['type' => "danger", 'message' => "No fue posible realizar la operación solicitada."]]);
        return redirect()->back();
    }

    private function comprobarFecha($fechaInicio, $fechaFin, $sedeEvento)
    {
        //TODO: Comprobar que no sea el primer evento el que tome.
        $fechaInicioOcupada = FechaEvento::whereBetween('InicioFechaEvento', array($fechaInicio, $fechaFin))->count();
        $fechaFinOcupada    = FechaEvento::whereBetween('FinFechaEvento', array($fechaInicio, $fechaFin))->count();
        if ($fechaInicioOcupada > 0 || $fechaFinOcupada > 0) {
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


    /**
     * Manda un correo con los datos del evento para solicitar aprobación
     *
     * @param array $input
     * @return void
     */
    private function enviarCorreo($input) {
        $input['sede'] = \App\Models\SedeEvento::get()->where('IdSedeEvento', $input['sede'])->first()->NombreSedeEvento;

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("zs18015382@estudiantes.uv.mx", "SistemaFCA Eventos");
        $email->setSubject('Solicitud de aprobación para "'.$input['nombre'].'"');
        $email->addContent(
            "text/html", view('emails.evento-registrado')->with('input', $input)->render()
        );
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));


        $users = \App\Models\Usuario::whereHas('roles', function ($query) {
            $query->where('ClaveRole', 'LIKE', 'CONTROL-GÉNERAL')
                ->orWhere('ClaveRole', 'LIKE', 'CONTROL-EVENTOS');
        })->get();

        foreach($users as $user) {
            $email->addTo($user->email, $user->name);
            $response = $sendgrid->send($email);
        }
    }
}
