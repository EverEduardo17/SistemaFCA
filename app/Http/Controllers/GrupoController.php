<?php

namespace App\Http\Controllers;

use App\Http\Requests\GrupoRequest;
use App\Models\Baja;
use App\Models\Cohorte;
use App\Models\Facultad;
use App\Models\Grupo;
use App\Models\Grupo_Estudiante;
use App\Models\Modalidad;
use App\Models\Motivo;
use App\Models\Periodo;
use App\Models\ProgramaEducativo;
use App\Models\Reprobado;
use App\Models\Titulacion;
use App\Models\Traslado;
use App\Models\Trayectoria;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GrupoController extends Controller
{
    public function index()
    {
        $idFCA = Facultad::where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('IdFacultad');
        return view('grupos.index', [
            'grupos'    => Grupo::where('IdFacultad', '=', $idFCA)->get()
        ]);
    }

    public function create()
    {
        $idFCA = Facultad::where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('IdFacultad');
        return view('grupos.create', [
            'grupos'        => new Grupo(),
            'periodos'      => DB::table('Periodo')
                ->orderBy('IdPeriodo', 'desc')
                ->get(),
            'cohortes'      => DB::table('Cohorte')
                ->orderBy('IdCohorte', 'desc')
                ->get(),
            'programas'     => DB::table('Programa_Educativo')
                ->where('IdFacultad', '=', $idFCA)
                ->get(),
            'facultad'      => $idFCA
        ]);
    }

    public function store(GrupoRequest $request)
    {
        //<--- Comprueba si existe algún grupo registrado en el cohorte y PE ingresado con el mismo nombre --->
        $existe      = DB::table('Grupo')->where([
            ['NombreGrupo',         '=', $request->NombreGrupo],
            ['IdProgramaEducativo', '=', $request->IdProgramaEducativo],
            ['IdCohorte',           '=', $request->IdCohorte]
        ])->count();
        if ($existe > 0) {
            Session::flash('flash', [['type' => "danger", 'message' => "El grupo '" . $request->NombreGrupo . "' ya se encuentra registrado en el cohorte seleccionado."]]);
            return redirect()->back();
        }
        //<--- Comprueba si existe algún grupo de LIS registrado en el cohorte ingresado --->
        $programaLis = ProgramaEducativo::where("NombreProgramaEducativo", "=", "Licenciatura en Ingeniería de Software")->value('IdProgramaEducativo');
        if ($request->IdProgramaEducativo == $programaLis) {
            $cohorteOcupado = DB::table('Grupo')->where([
                ['IdProgramaEducativo', '=', $programaLis],
                ['IdCohorte', '=', $request->IdCohorte]
            ])->count();
            if ($cohorteOcupado > 0) {
                $nombreCohorte = Cohorte::where("IdCohorte", "=", $request->IdCohorte)->value('NombreCohorte');
                Session::flash('flash', [['type' => "danger", 'message' => "El cohorte '" . $nombreCohorte . "' ya cuenta con un grupo de LIS registrado."]]);
                return redirect()->back();
            }
        }
        //<--- Comprueba si el número de periodos seleccionados es coherente, máximo 12 periodos --->
        if (($request->IdPeriodoActivo - $request->IdPeriodoInicio  > 12)) {
            Session::flash('flash', [['type' => "danger", 'message' => "Seleccione un rango de periodos válido."]]);
            return redirect()->back();
        }

        try {
            $input = $request->validated();
            $nombreGrupo            = strtoupper($input['NombreGrupo']);
            $input['NombreGrupo']   = $nombreGrupo;
            Grupo::create($input);
            Session::flash('flash', [['type' => "success", 'message' => "Grupo registrado correctamente."]]);
            return redirect()->route('grupos.index');
        } catch (\Throwable $throwable) {
            Session::flash('flash', [['type' => "danger", 'message' => "El Grupo NO pudo ser registrado."]]);
            return redirect()->route('grupos.index');
        }
    }

    public function show(Grupo $grupo)
    {
        $activos    = Grupo_Estudiante::where("Estado", "=",  "Activo")->where("IdGrupo", "=", $grupo->IdGrupo)->count();
        $inactivos  = Grupo_Estudiante::where("Estado", "<>", "Activo")->where("IdGrupo", "=", $grupo->IdGrupo)->count();
        return view('grupos.show', [
            'grupos'    => $grupo,
            'activos'   => $activos,
            'inactivos' => $inactivos,
        ]);
    }


    public function edit(Grupo $grupo)
    {
        $idFCA = Facultad::where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('IdFacultad');
        return view('grupos.edit', [
            'grupos'        => $grupo,
            'periodos'      => DB::table('Periodo')
                ->orderBy('IdPeriodo', 'desc')
                ->get(),
            'cohortes'      => DB::table('Cohorte')
                ->orderBy('IdCohorte', 'desc')
                ->get(),
            'programas'     => DB::table('Programa_Educativo')
                ->where('IdFacultad', '=', $idFCA)
                ->get(),
            'facultad'      => $idFCA
        ]);
    }

    public function update(GrupoRequest $request, Grupo $grupo)
    {
        $ocupado = DB::table('Grupo')->where([
            ['IdGrupo', '<>', $request->IdGrupo],
            ['NombreGrupo', '=', $request->NombreGrupo],
            ['IdProgramaEducativo', '=', $request->IdProgramaEducativo],
            ['IdCohorte', '=', $request->IdCohorte]
        ])->count();
        if ($ocupado > 0) {
            Session::flash('flash', [['type' => "danger", 'message' => "El grupo '" . $request->NombreGrupo . "' ya fue registrado en el cohorte seleccionado."]]);
            return redirect()->route('grupos.edit', $grupo);
        } else {
            //<--- Comprueba si existe algún grupo de LIS registrado en el cohorte ingresado --->
            $programaLis = ProgramaEducativo::where("NombreProgramaEducativo", "=", "Licenciatura en Ingeniería de Software")->value('IdProgramaEducativo');
            if ($request->IdProgramaEducativo == $programaLis) {
                $cohorteOcupado = DB::table('Grupo')->where([
                    ['IdGrupo', '<>', $request->IdGrupo],
                    ['IdProgramaEducativo', '=', $programaLis],
                    ['IdCohorte', '=', $request->IdCohorte]
                ])->count();
                if ($cohorteOcupado > 0) {
                    $nombreCohorte = Cohorte::where("IdCohorte", "=", $request->IdCohorte)->value('NombreCohorte');
                    Session::flash('flash', [['type' => "danger", 'message' => "El cohorte '" . $nombreCohorte . "' ya cuenta con un grupo de LIS registrado."]]);
                    return redirect()->back();
                }
            }
            //<--- Comprueba si el número de periodos seleccionados es coherente, máximo 9 periodos --->
            if (($request->IdPeriodoActivo - $request->IdPeriodoInicio  > 9)) {
                Session::flash('flash', [['type' => "danger", 'message' => "Seleccione un rango de periodos válido."]]);
                return redirect()->back();
            }

            try {
                $grupo->update($request->validated());
                Session::flash('flash', [['type' => "success", 'message' => "Grupo actualizado correctamente."]]);
                return redirect()->route('grupos.index');
            } catch (\Throwable $throwable) {
                Session::flash('flash', [['type' => "danger", 'message' => "El grupo NO pudo ser actualizado."]]);
                return redirect()->route('grupos.edit', $grupo);
            }
        }
    }

    public function destroy(Grupo $grupo)
    {
        $ocupado = Grupo_Estudiante::where('IdGrupo', $grupo->IdGrupo)->count();
        if ($ocupado > 0) {
            Session::flash('flash', [['type' => "danger", 'message' => "El grupo '" . $grupo->NombreGrupo . "' ya está ocupado, no puede ser eliminado."]]);
            return redirect()->route('grupos.index');
        } else {
            try {
                $grupo->forceDelete();
                Session::flash('flash', [['type' => "success", 'message' => "El grupo '" . $grupo->NombreGrupo . "' fue eliminado correctamente."]]);
                return redirect()->route('grupos.index');
            } catch (\Throwable $throwable) {
                Session::flash('flash', [['type' => "danger", 'message' => "El grupo '" . $grupo->NombreGrupo . "' NO pudo ser eliminado."]]);
                return redirect()->route('grupos.index');
            }
        }
    }


    //<---- Funciones para visualizar las tablas resumen de los grupos ---->

    public function mostrarGrupo($nombreCohorte, $nombreGrupo)
    {
        $nombreGrupoReal    = $this->getNombreGrupoLimpio($nombreGrupo);
        $idGrupo            = $this->getIdGrupo($nombreCohorte, $nombreGrupoReal);
        $informacion        = $this->getDatosResumen($idGrupo);

        return view('grupos.mostrarGrupo', [
            'grupos'            => Grupo::where("IdGrupo", "=", $idGrupo)->get(),
            'activoHombre'      => $informacion['activoHombre'],
            'activoMujer'       => $informacion['activoMujer'],
            'totalActivos'      => $informacion['totalActivos'],

            'egresadoHombre'    => $informacion['egresadoHombre'],
            'egresadoMujer'     => $informacion['egresadoMujer'],
            'totalEgresados'    => $informacion['totalEgresados'],

            'entranteHombre'    => $informacion['entranteHombre'],
            'entranteMujer'     => $informacion['entranteMujer'],
            'totalEntrantes'    => $informacion['totalEntrantes'],

            'salienteHombre'    => $informacion['salienteHombre'],
            'salienteMujer'     => $informacion['salienteMujer'],
            'totalSalientes'    => $informacion['totalSalientes'],

            'bajaHombre'        => $informacion['bajaHombre'],
            'bajaMujer'         => $informacion['bajaMujer'],
            'totalBajas'        => $informacion['totalBajas'],

            'nombreGrupo'       => $nombreGrupo,
        ]);
    }

    public function mostrarEstado($nombreCohorte, $nombreGrupo)
    {
        $nombreGrupoReal    = $this->getNombreGrupoLimpio($nombreGrupo);
        $idGrupo            = $this->getIdGrupo($nombreCohorte, $nombreGrupoReal);
        $informacion        = $this->getDatosEstado($idGrupo);

        return view('grupos.mostrarEstado', [
            'grupos'            => Grupo::where("IdGrupo", "=", $idGrupo)->get(),
            'activoHombre'      => $informacion['activoHombre'],
            'activoMujer'       => $informacion['activoMujer'],
            'totalActivos'      => $informacion['totalActivos'],

            'egresadoHombre'    => $informacion['egresadoHombre'],
            'egresadoMujer'     => $informacion['egresadoMujer'],
            'totalEgresados'    => $informacion['totalEgresados'],

            'bajaHombre'        => $informacion['bajaHombre'],
            'bajaMujer'         => $informacion['bajaMujer'],
            'totalBajas'        => $informacion['totalBajas'],

            'nombreGrupo'       => $nombreGrupo,
        ]);
    }

    public function mostrarEgresados($nombreCohorte, $nombreGrupo)
    {
        $nombreGrupoReal    = $this->getNombreGrupoLimpio($nombreGrupo);
        $idGrupo            = $this->getIdGrupo($nombreCohorte, $nombreGrupoReal);
        $informacion        = $this->getDatosEgresados($idGrupo);
        $grupo              = Grupo::where('IdGrupo', '=', $idGrupo)->get();
        $periodoInicio      = $grupo[0]->IdPeriodoInicio + 7;
        $periodos           = Periodo::whereBetween('IdPeriodo', array($periodoInicio, $periodoInicio + 4))->get();
        $nombrePeriodos     = [];
        $contador           = 0;
        foreach ($periodos as $periodo) {
            $nombrePeriodos[$contador] = str_replace(" ", "_", $periodo->NombrePeriodo);
            $contador++;
        }
        $modalidades        = $this->getModalidades($grupo[0]->IdProgramaEducativo);
        return view('grupos.mostrarEgresados', [
            'grupos'            => $grupo,
            'hombre'            => $informacion['activoHombre'],
            'mujer'             => $informacion['activoMujer'],
            'totalEgresados'    => $informacion['totalActivos'],
            'egresadosPeriodo'  => $informacion['cantidadesPeriodos'],
            'egresadosModalidad' => $informacion['cantidadesModalidad'],
            'modalidades'       => $modalidades,
            'periodos'          => $periodos,
            'nombresPeriodos'    => $nombrePeriodos,
            'totalPeriodos'     => $periodos->count(),
            'totalModalidades'  => $modalidades->count(),
            'nombreGrupo'       => $nombreGrupo,
        ]);
    }

    public function mostrarEgresadosPeriodo($nombreCohorte, $nombreGrupo, $nombrePeriodo)
    {
        $nombreGrupoReal    = $this->getNombreGrupoLimpio($nombreGrupo);
        $nombrePeriodoReal    = $this->getNombrePeriodoLimpio($nombrePeriodo);
        $periodo            = Periodo::where('NombrePeriodo', '=', $nombrePeriodoReal)->get()->last();
        $idGrupo            = $this->getIdGrupo($nombreCohorte, $nombreGrupoReal);
        $alumnos            = Grupo_Estudiante::where('Estado', '=', 'Egresado')->where('IdGrupo', '=', $idGrupo)->get();
        $estudiantes        = [];
        foreach ($alumnos as $alumno) {
            $titulacion     = Titulacion::where('IdTrayectoria', '=', $alumno->IdTrayectoria)->get()->last();
            if ($titulacion->IdPeriodoEgreso == $periodo->IdPeriodo) {
                $estudiantes[] = $titulacion;
            }
        }
        $grupo              = Grupo::where('IdGrupo', '=', $idGrupo)->get();
        $periodos           = Periodo::where('NombrePeriodo', '=', $nombrePeriodoReal)->get();
        $modalidades        = Modalidad::where('TipoModalidad', '=', 'Titulación')->get();

        return view('grupos.mostrarEgresadosPeriodo', [
            'grupos'            => $grupo,
            'estudiantes'       => $estudiantes,
            'modalidades'       => $modalidades,
            'periodos'          => $periodos,
            'nombreGrupo'       => $nombreGrupo,
        ]);
    }

    public function mostrarTraslados($nombreCohorte, $nombreGrupo)
    {
        $nombreGrupoReal    = $this->getNombreGrupoLimpio($nombreGrupo);
        $idGrupo            = $this->getIdGrupo($nombreCohorte, $nombreGrupoReal);
        $informacion        = $this->getDatosTraslados($idGrupo);
        return view('grupos.mostrarTraslados', [
            'grupos'                =>  Grupo::where('IdGrupo', '=', $idGrupo)->get(),
            'estudiantesEntrantes'  => $informacion['estudiantesEntrantes'],
            'estudiantesSalientes'  => $informacion['estudiantesSalientes'],
            'nombreGrupo'       => $nombreGrupo,
        ]);
    }

    public function mostrarReprobados($nombreCohorte, $nombreGrupo)
    {
        $nombreGrupoReal    = $this->getNombreGrupoLimpio($nombreGrupo);
        $idGrupo            = $this->getIdGrupo($nombreCohorte, $nombreGrupoReal);
        $informacion        = $this->getDatosReprobados($idGrupo);
        $grupo              = Grupo::where('IdGrupo', '=', $idGrupo)->get();
        $periodoInicio      = $grupo[0]->IdPeriodoInicio;
        $periodos           = Periodo::whereBetween('IdPeriodo', array($periodoInicio, $periodoInicio + 12))->get();
        $nombresPeriodos     = [];
        $contador           = 0;
        foreach ($periodos as $periodo) {
            $nombresPeriodos[$contador] = str_replace(" ", "_", $periodo->NombrePeriodo);
            $contador++;
        }
        return view('grupos.mostrarReprobados', [
            'grupos'            => $grupo,
            'hombre'            => $informacion['hombre'],
            'mujer'             => $informacion['mujer'],
            'totalReprobados'   => $informacion['totalReprobados'],
            'reprobadosPeriodo' => $informacion['cantidadesPeriodos'],
            'periodos'          => $periodos,
            'nombresPeriodos'    => $nombresPeriodos,
            'totalPeriodos'     => $periodos->count(),
            'nombreGrupo'       => $nombreGrupo,
        ]);
    }

    public function mostrarReprobadosPeriodo($nombreCohorte, $nombreGrupo, $nombrePeriodo)
    {
        $nombreGrupoReal    = $this->getNombreGrupoLimpio($nombreGrupo);
        $nombrePeriodoReal    = $this->getNombrePeriodoLimpio($nombrePeriodo);
        $periodo            = Periodo::where('NombrePeriodo', '=', $nombrePeriodoReal)->get()->last();
        $idGrupo            = $this->getIdGrupo($nombreCohorte, $nombreGrupoReal);
        $alumnos            = Grupo_Estudiante::where('IdGrupo', '=', $idGrupo)->get();
        $estudiantes        = [];
        foreach ($alumnos as $alumno) {
            $reprobado      = Reprobado::where('IdTrayectoria', '=', $alumno->IdTrayectoria)->get()->last();
            if ($reprobado != null && $reprobado->IdPeriodo == $periodo->IdPeriodo) {
                $estudiantes[] = $reprobado;
            }
        }
        $grupo              = Grupo::where('IdGrupo', '=', $idGrupo)->get();
        $periodos           = Periodo::where('NombrePeriodo', '=', $nombrePeriodoReal)->get();
        $modalidades        = Modalidad::where('TipoModalidad', '=', 'Titulación')->get();

        return view('grupos.mostrarReprobadosPeriodo', [
            'grupos'            => $grupo,
            'estudiantes'       => $estudiantes,
            'modalidades'       => $modalidades,
            'periodos'          => $periodos,
            'nombreGrupo'       => $nombreGrupo,
        ]);
    }


    public function mostrarBajas($nombreCohorte, $nombreGrupo)
    {
        $nombreGrupoReal    = $this->getNombreGrupoLimpio($nombreGrupo);
        $idGrupo            = $this->getIdGrupo($nombreCohorte, $nombreGrupoReal);
        $informacion        = $this->getDatosBajas($idGrupo);
        $grupo              = Grupo::where('IdGrupo', '=', $idGrupo)->get();
        $motivos            = Motivo::get();
        return view('grupos.mostrarBajas', [
            'grupos'            => $grupo,
            'hombreTemporal'    => $informacion['hombreTemporal'],
            'mujerTemporal'     => $informacion['mujerTemporal'],
            'hombreDefinitivo'  => $informacion['hombreDefinitivo'],
            'mujerDefinitivo'   => $informacion['mujerDefinitivo'],
            'resultados'        => $informacion['bajasMotivos'],
            'motivos'           => $motivos,
            'nombreGrupo'       => $nombreGrupo,
        ]);
    }

    //<---- Métodos Para imprimir tablas ---->

    public function imprimirGrupo($nombreCohorte, $nombreGrupo)
    {
        $nombreGrupoReal    = $this->getNombreGrupoLimpio($nombreGrupo);
        $idGrupo            = $this->getIdGrupo($nombreCohorte, $nombreGrupoReal);
        $informacion        = $this->getDatosResumen($idGrupo);
        $pdf = PDF::loadView('grupos.pdf.imprimirGrupo', [
            'grupos'            => Grupo::where("IdGrupo", "=", $idGrupo)->get(),
            'activoHombre'      => $informacion['activoHombre'],
            'activoMujer'       => $informacion['activoMujer'],
            'totalActivos'      => $informacion['totalActivos'],

            'egresadoHombre'    => $informacion['egresadoHombre'],
            'egresadoMujer'     => $informacion['egresadoMujer'],
            'totalEgresados'    => $informacion['totalEgresados'],

            'entranteHombre'    => $informacion['entranteHombre'],
            'entranteMujer'     => $informacion['entranteMujer'],
            'totalEntrantes'    => $informacion['totalEntrantes'],

            'salienteHombre'    => $informacion['salienteHombre'],
            'salienteMujer'     => $informacion['salienteMujer'],
            'totalSalientes'    => $informacion['totalSalientes'],

            'bajaHombre'        => $informacion['bajaHombre'],
            'bajaMujer'         => $informacion['bajaMujer'],
            'totalBajas'        => $informacion['totalBajas'],

            'nombreGrupo'       => $nombreGrupo,
            'fecha'                     => Carbon::now()->format('j/m/Y'),
            'hora'                      => Carbon::now()->format('h:i:s A'),
        ]);
        return $pdf->stream('Resumen_' . $nombreGrupo . '_' . $nombreCohorte . '.pdf');
    }

    public function imprimirEstado($nombreCohorte, $nombreGrupo)
    {
        $nombreGrupoReal    = $this->getNombreGrupoLimpio($nombreGrupo);
        $idGrupo            = $this->getIdGrupo($nombreCohorte, $nombreGrupoReal);
        $informacion        = $this->getDatosEstado($idGrupo);

        $pdf = PDF::loadView('grupos.pdf.imprimirEstado', [
            'grupos'            => Grupo::where("IdGrupo", "=", $idGrupo)->get(),
            'activoHombre'      => $informacion['activoHombre'],
            'activoMujer'       => $informacion['activoMujer'],
            'totalActivos'      => $informacion['totalActivos'],

            'egresadoHombre'    => $informacion['egresadoHombre'],
            'egresadoMujer'     => $informacion['egresadoMujer'],
            'totalEgresados'    => $informacion['totalEgresados'],

            'bajaHombre'        => $informacion['bajaHombre'],
            'bajaMujer'         => $informacion['bajaMujer'],
            'totalBajas'        => $informacion['totalBajas'],

            'fecha'                     => Carbon::now()->format('j/m/Y'),
            'hora'                      => Carbon::now()->format('h:i:s A'),
        ]);
        return $pdf->stream('Estado_' . $nombreGrupo . '_' . $nombreCohorte . '.pdf');
    }

    public function imprimirEgresados($nombreCohorte, $nombreGrupo)
    {
        $nombreGrupoReal    = $this->getNombreGrupoLimpio($nombreGrupo);
        $idGrupo            = $this->getIdGrupo($nombreCohorte, $nombreGrupoReal);
        $informacion        = $this->getDatosEgresados($idGrupo);
        $grupo              = Grupo::where('IdGrupo', '=', $idGrupo)->get();
        $periodoInicio      = $grupo[0]->IdPeriodoInicio + 7;
        $periodos           = Periodo::whereBetween('IdPeriodo', array($periodoInicio, $periodoInicio + 4))->get();
        $modalidades        = $this->getModalidades($grupo[0]->IdProgramaEducativo);
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('grupos.pdf.imprimirEgresados', [
            'grupos'            => $grupo,
            'hombre'            => $informacion['activoHombre'],
            'mujer'             => $informacion['activoMujer'],
            'totalEgresados'    => $informacion['totalActivos'],
            'egresadosPeriodo'  => $informacion['cantidadesPeriodos'],
            'egresadosModalidad' => $informacion['cantidadesModalidad'],
            'modalidades'       => $modalidades,
            'periodos'          => $periodos,
            'totalPeriodos'     => $periodos->count(),
            'totalModalidades'  => $modalidades->count(),
            'fecha'                     => Carbon::now()->format('j/m/Y'),
            'hora'                      => Carbon::now()->format('h:i:s A'),
        ]);
        return $pdf->stream('Egresados_' . $nombreGrupo . '_' . $nombreCohorte . '.pdf');
    }

    public function imprimirTraslados($nombreCohorte, $nombreGrupo)
    {
        $nombreGrupoReal    = $this->getNombreGrupoLimpio($nombreGrupo);
        $idGrupo            = $this->getIdGrupo($nombreCohorte, $nombreGrupoReal);
        $informacion        = $this->getDatosTraslados($idGrupo);
        $pdf = PDF::loadView('grupos.pdf.imprimirTraslados', [
            'grupos'                =>  Grupo::where('IdGrupo', '=', $idGrupo)->get(),
            'estudiantesEntrantes'  => $informacion['estudiantesEntrantes'],
            'estudiantesSalientes'  => $informacion['estudiantesSalientes'],

            'fecha'                     => Carbon::now()->format('j/m/Y'),
            'hora'                      => Carbon::now()->format('h:i:s A'),
        ]);
        return $pdf->stream('Traslados_' . $nombreGrupo . '_' . $nombreCohorte . '.pdf');
    }

    public function imprimirReprobados($nombreCohorte, $nombreGrupo)
    {
        $nombreGrupoReal    = $this->getNombreGrupoLimpio($nombreGrupo);
        $idGrupo            = $this->getIdGrupo($nombreCohorte, $nombreGrupoReal);
        $informacion        = $this->getDatosReprobados($idGrupo);
        $grupo              = Grupo::where('IdGrupo', '=', $idGrupo)->get();
        $periodoInicio      = $grupo[0]->IdPeriodoInicio;
        $periodos           = Periodo::whereBetween('IdPeriodo', array($periodoInicio, $periodoInicio + 12))->get();

        $pdf = Pdf::loadView('grupos.pdf.imprimirReprobados', [
            'grupos'            => $grupo,
            'hombre'            => $informacion['hombre'],
            'mujer'             => $informacion['mujer'],
            'totalReprobados'   => $informacion['totalReprobados'],
            'reprobadosPeriodo' => $informacion['cantidadesPeriodos'],
            'periodos'          => $periodos,
            'totalPeriodos'     => $periodos->count(),
            'fecha'                     => Carbon::now()->format('j/m/Y'),
            'hora'                      => Carbon::now()->format('h:i:s A'),
        ]);
        return $pdf->stream('Reprobados_' . $nombreGrupo . '_' . $nombreCohorte . '.pdf');
    }

    public function imprimirBajas($nombreCohorte, $nombreGrupo)
    {
        $nombreGrupoReal    = $this->getNombreGrupoLimpio($nombreGrupo);
        $idGrupo            = $this->getIdGrupo($nombreCohorte, $nombreGrupoReal);
        $informacion        = $this->getDatosBajas($idGrupo);
        $grupo              = Grupo::where('IdGrupo', '=', $idGrupo)->get();
        $motivos            = Motivo::get();

        $pdf = PDF::loadView('grupos.pdf.imprimirBajas', [
            'grupos'            => $grupo,
            'hombreTemporal'    => $informacion['hombreTemporal'],
            'mujerTemporal'     => $informacion['mujerTemporal'],
            'hombreDefinitivo'  => $informacion['hombreDefinitivo'],
            'mujerDefinitivo'   => $informacion['mujerDefinitivo'],
            'resultados'        => $informacion['bajasMotivos'],
            'motivos'           => $motivos,
            'nombreGrupo'       => $nombreGrupo,
            'fecha'                     => Carbon::now()->format('j/m/Y'),
            'hora'                      => Carbon::now()->format('h:i:s A'),
        ]);
        return $pdf->stream('Bajas_' . $nombreGrupo . '_' . $nombreCohorte . '.pdf');
    }


    //<---- Métodos auxiliares ---->

    public function contarEstudiantes($idGrupo)
    {
        $activos = Grupo_Estudiante::where("Estado", "=", "Activo")
            ->where("IdGrupo", "=", $idGrupo)->count();
        $inactivos = Grupo_Estudiante::where("Estado", "<>", "Activo")
            ->where("IdGrupo", "=", $idGrupo)->count();
        return [$activos, $inactivos];
    }

    private function getCantidadesGenero($estudiantes)
    {
        $hombre = 0;
        $mujer = 0;

        foreach ($estudiantes as $estudiante) {
            $idDatosPersonales = DB::table('Trayectoria')
                ->where('IdTrayectoria', '=', $estudiante->IdTrayectoria)
                ->value('IdDatosPersonales');
            $genero = DB::table('DatosPersonales')
                ->where('IdDatosPersonales', '=', $idDatosPersonales)
                ->value('genero');
            if ($genero == "Hombre") {
                $hombre++;
            } else if ($genero == "Mujer") {
                $mujer++;
            }
        }
        return [$hombre, $mujer];
    }

    private function getEstudiantesPorPeriodo($estudiantes, $idGrupo)
    {
        $grupo              = Grupo::where('IdGrupo', '=', $idGrupo)->get()->last();
        $periodoInicio      = $grupo->IdPeriodoInicio + 7;
        $periodos           = Periodo::whereBetween('IdPeriodo', array($periodoInicio, $periodoInicio + 4))->get();
        $hombres            = 0;
        $mujeres            = 0;
        $cantidades         = [];
        $contador           = 0;
        foreach ($periodos as $periodo) {
            foreach ($estudiantes as $clave => $estudiante) {
                $titulacion = Titulacion::where('IdTrayectoria', '=', $estudiante->IdTrayectoria)->get()->last();
                if ($periodo->IdPeriodo == $titulacion->IdPeriodoEgreso) {
                    $idDatosPersonales = DB::table('Trayectoria')
                        ->where('IdTrayectoria', '=', $estudiante->IdTrayectoria)
                        ->value('IdDatosPersonales');
                    $genero = DB::table('DatosPersonales')
                        ->where('IdDatosPersonales', '=', $idDatosPersonales)
                        ->value('genero');
                    if ($genero == "Hombre") {
                        $hombres = $hombres + 1;
                    } else if ($genero == "Mujer") {
                        $mujeres = $mujeres + 1;
                    }
                    unset($estudiantes[$clave]);
                }
            }
            $cantidades[$contador] = ['hombre' => $hombres, 'mujer' => $mujeres];
            $hombres = 0;
            $mujeres = 0;
            $contador++;
        }
        return $cantidades;
    }

    private function getReprobadosPorPeriodo($estudiantes, $idGrupo)
    {
        $grupo              = Grupo::where('IdGrupo', '=', $idGrupo)->get()->last();
        $periodoInicio      = $grupo->IdPeriodoInicio;
        $periodos           = Periodo::whereBetween('IdPeriodo', array($periodoInicio, $periodoInicio + 9))->get();
        $hombres            = 0;
        $mujeres            = 0;
        $cantidades         = [];
        $contador           = 0;
        foreach ($periodos as $periodo) {
            foreach ($estudiantes as $clave => $estudiante) {
                $reprobado = Reprobado::where('IdTrayectoria', '=', $estudiante->IdTrayectoria)->get()->last();
                if ($reprobado != null && $periodo->IdPeriodo == $reprobado->IdPeriodo) {
                    $idDatosPersonales = DB::table('Trayectoria')
                        ->where('IdTrayectoria', '=', $estudiante->IdTrayectoria)
                        ->value('IdDatosPersonales');
                    $genero = DB::table('DatosPersonales')
                        ->where('IdDatosPersonales', '=', $idDatosPersonales)
                        ->value('genero');
                    if ($genero == "Hombre") {
                        $hombres = $hombres + 1;
                    } else if ($genero == "Mujer") {
                        $mujeres = $mujeres + 1;
                    }
                    unset($estudiantes[$clave]);
                }
            }
            $cantidades[$contador] = ['hombre' => $hombres, 'mujer' => $mujeres];
            $hombres = 0;
            $mujeres = 0;
            $contador++;
        }
        return $cantidades;
    }

    private function getEstudiantesPorModalidad($estudiantes)
    {
        $modalidades        = Modalidad::where('TipoModalidad', '=', 'Titulación')->get();
        $hombres            = 0;
        $mujeres            = 0;
        $cantidades         = [];
        $contador           = 0;
        foreach ($modalidades as $modalidad) {
            foreach ($estudiantes as $clave => $estudiante) {
                $titulacion = Titulacion::where('IdTrayectoria', '=', $estudiante->IdTrayectoria)->get()->last();
                if ($modalidad->IdModalidad == $titulacion->IdModalidad) {
                    $idDatosPersonales = DB::table('Trayectoria')
                        ->where('IdTrayectoria', '=', $estudiante->IdTrayectoria)
                        ->value('IdDatosPersonales');
                    $genero = DB::table('DatosPersonales')
                        ->where('IdDatosPersonales', '=', $idDatosPersonales)
                        ->value('genero');
                    if ($genero == "Hombre") {
                        $hombres = $hombres + 1;
                    } else if ($genero == "Mujer") {
                        $mujeres = $mujeres + 1;
                    }
                    unset($estudiantes[$clave]);
                }
            }
            $cantidades[$contador] = ['hombre' => $hombres, 'mujer' => $mujeres];
            $hombres = 0;
            $mujeres = 0;
            $contador++;
        }
        return $cantidades;
    }

    private function getEstudiantesPorMotivo($estudiantes)
    {
        $motivos            = Motivo::get();
        $hombres            = 0;
        $mujeres            = 0;
        $cantidades         = [];
        $contador           = 0;
        foreach ($motivos as $motivo) {
            foreach ($estudiantes as $clave => $estudiante) {
                $baja = Baja::where('IdTrayectoria', '=', $estudiante->IdTrayectoria)->get()->last();
                if ($motivo->IdMotivo == $baja->IdMotivo) {
                    $idDatosPersonales = DB::table('Trayectoria')
                        ->where('IdTrayectoria', '=', $estudiante->IdTrayectoria)
                        ->value('IdDatosPersonales');
                    $genero = DB::table('DatosPersonales')
                        ->where('IdDatosPersonales', '=', $idDatosPersonales)
                        ->value('genero');
                    if ($genero == "Hombre") {
                        $hombres = $hombres + 1;
                    } else if ($genero == "Mujer") {
                        $mujeres = $mujeres + 1;
                    }
                    unset($estudiantes[$clave]);
                }
            }
            $cantidades[$contador] = ['hombre' => $hombres, 'mujer' => $mujeres];
            $hombres = 0;
            $mujeres = 0;
            $contador++;
        }
        return $cantidades;
    }

    private function getNombreGrupoLimpio($nombreGrupo)
    {
        return str_replace("-", " ", $nombreGrupo);
    }

    private function getNombrePeriodoLimpio($nombrePeriodo)
    {
        return str_replace("_", " ", $nombrePeriodo);
    }

    private function getIdGrupo($nombreCohorte, $nombreGrupoReal)
    {
        $idCohorte      = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->value('IdCohorte');
        return Grupo::where('NombreGrupo', '=', $nombreGrupoReal)->where('IdCohorte', '=', $idCohorte)->value('IdGrupo');
    }

    private function getModalidades($idProgramaEducativo)
    {
        $idLIS              = ProgramaEducativo::where('AcronimoProgramaEducativo', '=', 'LIS')->value('IdProgramaEducativo');
        $idLSCA              = ProgramaEducativo::where('AcronimoProgramaEducativo', '=', 'LSCA')->value('IdProgramaEducativo');
        if ($idProgramaEducativo == $idLIS || $idProgramaEducativo == $idLSCA) {
            return Modalidad::where('TipoModalidad', '=', 'Titulación')->get();
        } else {
            return Modalidad::where('TipoModalidad', '=', 'Titulación')->where('NombreModalidad', '<>', 'Trabajo Práctico')->get();
        }
    }

    //<---- Métodos de apoyo para obtener los datos---->

    private function getDatosResumen($idGrupo)
    {
        $estudiantes    = DB::table('Grupo_Estudiante')
            ->where('Estado', '=', 'Activo')
            ->where('TipoTraslado', '=', null)
            ->where('IdGrupo', '=', $idGrupo)
            ->get();
        $resultados     = $this->getCantidadesGenero($estudiantes);
        $activoHombre   = $resultados[0];
        $activoMujer    = $resultados[1];
        $totalActivos   = $activoHombre + $activoMujer;

        $estudiantes    = DB::table('Grupo_Estudiante')
            ->where('Estado', '=', 'Egresado')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();

        $resultados     = $this->getCantidadesGenero($estudiantes);
        $egresadoHombre = $resultados[0];
        $egresadoMujer  = $resultados[1];
        $totalEgresados = $egresadoHombre + $egresadoMujer;

        $estudiantes    = DB::table('Grupo_Estudiante')
            ->where('Estado', '=', 'Activo')
            ->where('TipoTraslado', '=', 'Entrante')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();

        $resultados     = $this->getCantidadesGenero($estudiantes);
        $entranteHombre = $resultados[0];
        $entranteMujer  = $resultados[1];
        $totalEntrantes = $entranteHombre + $entranteMujer;

        $estudiantes = DB::table('Grupo_Estudiante')
            ->where('Estado', '=', 'Activo')
            ->where('TipoTraslado', '=', 'Saliente')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();

        $resultados     = $this->getCantidadesGenero($estudiantes);
        $salienteHombre = $resultados[0];
        $salienteMujer  = $resultados[1];
        $totalSalientes = $salienteHombre + $salienteMujer;

        $estudiantes = DB::table('Grupo_Estudiante')
            ->where('Estado', '=', 'Baja')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();

        $resultados     = $this->getCantidadesGenero($estudiantes);
        $bajaHombre     = $resultados[0];
        $bajaMujer      = $resultados[1];
        $totalBajas     = $bajaHombre + $bajaMujer;

        return [
            'activoHombre'      => $activoHombre,
            'activoMujer'       => $activoMujer,
            'totalActivos'      => $totalActivos,
            'egresadoHombre'    => $egresadoHombre,
            'egresadoMujer'     => $egresadoMujer,
            'totalEgresados'    => $totalEgresados,
            'entranteHombre'    => $entranteHombre,
            'entranteMujer'     => $entranteMujer,
            'totalEntrantes'    => $totalEntrantes,
            'salienteHombre'    => $salienteHombre,
            'salienteMujer'     => $salienteMujer,
            'totalSalientes'    => $totalSalientes,
            'bajaHombre'        => $bajaHombre,
            'bajaMujer'         => $bajaMujer,
            'totalBajas'        => $totalBajas,
        ];
    }

    private function getDatosEstado($idGrupo)
    {
        $estudiantes = DB::table('Grupo_Estudiante')
            ->where('Estado', '=', 'Activo')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();
        $resultados = $this->getCantidadesGenero($estudiantes);
        $activoHombre = $resultados[0];
        $activoMujer = $resultados[1];
        $totalActivos  = $activoHombre + $activoMujer;

        $estudiantes = DB::table('Grupo_Estudiante')
            ->where('Estado', '=', 'Egresado')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();

        $resultados = $this->getCantidadesGenero($estudiantes);
        $egresadoHombre = $resultados[0];
        $egresadoMujer = $resultados[1];
        $totalEgresados  = $egresadoHombre + $egresadoMujer;

        $estudiantes = DB::table('Grupo_Estudiante')
            ->where('Estado', '=', 'Baja')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();

        $resultados = $this->getCantidadesGenero($estudiantes);
        $bajaHombre = $resultados[0];
        $bajaMujer = $resultados[1];
        $totalBajas  = $bajaHombre + $bajaMujer;

        return [
            'activoHombre'      => $activoHombre,
            'activoMujer'       => $activoMujer,
            'totalActivos'      => $totalActivos,
            'egresadoHombre'    => $egresadoHombre,
            'egresadoMujer'     => $egresadoMujer,
            'totalEgresados'    => $totalEgresados,
            'bajaHombre'        => $bajaHombre,
            'bajaMujer'         => $bajaMujer,
            'totalBajas'        => $totalBajas,
        ];
    }

    private function getDatosEgresados($idGrupo)
    {
        $estudiantes        = Grupo_Estudiante::where('Estado', '=', 'Egresado')->where('IdGrupo', '=', $idGrupo)->get();
        $resultados         = $this->getCantidadesGenero($estudiantes);
        $activoHombre       = $resultados[0];
        $activoMujer        = $resultados[1];
        $totalActivos       = $activoHombre + $activoMujer;
        $cantidadesPeriodos = $this->getEstudiantesPorPeriodo($estudiantes, $idGrupo);
        $estudiantes        = Grupo_Estudiante::where('Estado', '=', 'Egresado')->where('IdGrupo', '=', $idGrupo)->get();
        $cantidadesModalidad = $this->getEstudiantesPorModalidad($estudiantes);
        return [
            'activoHombre'          => $activoHombre,
            'activoMujer'           => $activoMujer,
            'totalActivos'          => $totalActivos,
            'cantidadesPeriodos'    => $cantidadesPeriodos,
            'cantidadesModalidad'   => $cantidadesModalidad,
        ];
    }

    private function getDatosTraslados($idGrupo)
    {
        $alumnos            = Grupo_Estudiante::where('TipoTraslado', '<>', 'null')->where('IdGrupo', '=', $idGrupo)->get();
        $estudiantesSalientes        = [];
        $estudiantesEntrantes        = [];
        foreach ($alumnos as $alumno) {
            $traslado     = Traslado::where('IdTrayectoria', '=', $alumno->IdTrayectoria)->get()->last();
            if ($alumno->TipoTraslado == 'Entrante') {
                $estudiantesEntrantes[] = $traslado;
            } elseif ($alumno->TipoTraslado == 'Saliente') {
                $estudiantesSalientes[] = $traslado;
            }
        }
        return ['estudiantesEntrantes' => $estudiantesEntrantes, 'estudiantesSalientes' => $estudiantesSalientes];
    }

    private function getDatosReprobados($idGrupo)
    {
        $estudiantes        = Grupo_Estudiante::where('IdGrupo', '=', $idGrupo)->get();
        foreach ($estudiantes as $clave => $estudiante) {
            $reprobado = Reprobado::where('IdTrayectoria', '=', $estudiante->IdTrayectoria)->get()->last();
            if ($reprobado == null) {
                unset($estudiantes[$clave]);
            }
        }
        $resultados         = $this->getCantidadesGenero($estudiantes);
        $hombre             = $resultados[0];
        $mujer              = $resultados[1];
        $totalReprobados    = $hombre + $mujer;
        $cantidadesPeriodos = $this->getReprobadosPorPeriodo($estudiantes, $idGrupo);
        return [
            'hombre'            => $hombre,
            'mujer'             => $mujer,
            'totalReprobados'   => $totalReprobados,
            'cantidadesPeriodos'    => $cantidadesPeriodos,
        ];
    }

    private function getDatosBajas($idGrupo)
    {
        $estudiantes            = Grupo_Estudiante::where('Estado', '=', 'Baja')->where('IdGrupo', '=', $idGrupo)->get();
        $bajasTemporales        = [];
        $bajasDefinitivas       = [];
        foreach ($estudiantes as $estudiante) {
            $baja = Baja::where('IdTrayectoria', '=', $estudiante->IdTrayectoria)->get()->last();
            if ($baja->TipoBaja == "Temporal") {
                $bajasTemporales[] = $estudiante;
            } else {
                $bajasDefinitivas[] = $estudiante;
            }
        }
        $resultadosTemporal     = $this->getCantidadesGenero($bajasTemporales);
        $hombreTemporal         = $resultadosTemporal[0];
        $mujerTemporal          = $resultadosTemporal[1];
        $resultadosDefinitivo   = $this->getCantidadesGenero($bajasDefinitivas);
        $hombreDefinitivo       = $resultadosDefinitivo[0];
        $mujerDefinitivo        = $resultadosDefinitivo[1];
        $bajasMotivos           = $this->getEstudiantesPorMotivo($estudiantes);

        return [
            'hombreTemporal'    => $hombreTemporal,
            'mujerTemporal'     => $mujerTemporal,
            'hombreDefinitivo'  => $hombreDefinitivo,
            'mujerDefinitivo'   => $mujerDefinitivo,
            'bajasMotivos'      => $bajasMotivos,
        ];
    }
}
