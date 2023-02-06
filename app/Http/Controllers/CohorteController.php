<?php

namespace App\Http\Controllers;

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
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class CohorteController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function show($nombreCohorte)
    {
        $idCohorte      = Cohorte::where('NombreCohorte', $nombreCohorte)->value('IdCohorte');
        $idFCA          = Facultad::where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('idFacultad');
        $grupos         = Grupo::where('IdCohorte', '=', $idCohorte)->get();
        $nombreGrupos    = [];
        $contador       = 0;
        foreach($grupos as $grupo){
            $nombreGrupos[$contador] = str_replace(" ", "-", $grupo->NombreGrupo);
            $contador++;
        }
        return view('cohorte.show', [
            'cohortes'      => DB::table('Cohorte')
                ->orderBy('IdCohorte', 'desc')
                ->get(),
            'programas'     => ProgramaEducativo::where('IdFacultad', '=', $idFCA)
                ->get(),
            'grupos'        => $grupos,
            'periodos'      => Periodo::orderBy("IdPeriodo", "desc")->get(),
            'idCohorte'     => $idCohorte,
            'nombreCohorte' => $nombreCohorte,
            'modalidades'   => Modalidad::get(),
            'idFCA'         => $idFCA,
            'nombreGrupos'  => $nombreGrupos,
        ]);
    }

    public function mostrarCohorte()
    {
        $nombreCohorte  = Cohorte::orderBy('IdCohorte', 'desc')->get()->first();
        $idCohorte      = Cohorte::where('NombreCohorte', $nombreCohorte->NombreCohorte)->value('IdCohorte');
        $idFCA          = Facultad::where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('idFacultad');
        $grupos         = Grupo::where('IdCohorte', '=', $idCohorte)->get();
        $nombreGrupos    = [];
        $contador       = 0;
        foreach($grupos as $grupo){
            $nombreGrupos[$contador] = str_replace(" ", "-", $grupo->NombreGrupo);
            $contador++;
        }
        return view('cohorte.show', [
            'cohortes'      => DB::table('Cohorte')
                ->orderBy('IdCohorte', 'desc')
                ->get(),
            'programas'     => ProgramaEducativo::where('IdFacultad', '=', $idFCA)
                ->get(),
            'grupos'        => Grupo::where('IdCohorte', '=', $idCohorte)->get(),
            'periodos'      => Periodo::get(),
            'idCohorte'     => $idCohorte,
            'nombreCohorte' => $nombreCohorte->NombreCohorte,
            'modalidades'   => Modalidad::get(),
            'idFCA'         => $idFCA,
            'nombreGrupos'  => $nombreGrupos,
        ]);
    }

    public function agregarEstudiante($nombreCohorte, $nombreGrupo)
    {
        $cohorte            = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->get()->last();
        $grupo              = Grupo::where('NombreGrupo', '=', $nombreGrupo)->where('IdCohorte', '=', $cohorte->IdCohorte)->get()->last();
        $programaEducativo  = ProgramaEducativo::where('IdProgramaEducativo', $grupo->IdProgramaEducativo)->get()->last();
        return view('estudiantes.crearCohorte', [
            'grupo'             => $grupo,
            'cohorte'           => $cohorte,
            'modalidades'       => Modalidad::where("TipoModalidad", "=", "Entrada")->get(),
            'programaEducativo' => $programaEducativo,
        ]);
    }

    //<---- Funciones para visualizar las tablas resumen del cohorte ---->

    public function mostrarResumen($nombreCohorte)
    {
        $cohorte                = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->get();
        $programasEducativos    = ProgramaEducativo::get();

        $gruposPorPrograma      = $this->clasificarGrupos($cohorte);
        $informacion            = $this->getDatosResumen($gruposPorPrograma);
        $informacionPorPrograma = $informacion['informacionPorPrograma'];
        $ultimoPeriodo          = $informacion['ultimoPeriodo'];

        return view('cohorte.mostrarResumen', [
            'programas'                 => $programasEducativos,
            'tamanioProgramas'          => count($programasEducativos),
            'cohorte'                   => $cohorte[0],
            'informacionPorPrograma'    => $informacionPorPrograma,
            'ultimoPeriodo'             => Periodo::where('IdPeriodo', '=', $ultimoPeriodo)->value('NombrePeriodo')
        ]);
    }

    public function mostrarEstado($nombreCohorte)
    {
        $cohorte                = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->get();
        $programasEducativos    = ProgramaEducativo::get();
        $gruposPorPrograma      = $this->clasificarGrupos($cohorte);
        $informacion            = $this->getDatosEstado($gruposPorPrograma);
        $informacionPorPrograma = $informacion['informacionPorPrograma'];
        $ultimoPeriodo          = $informacion['ultimoPeriodo'];


        return view('cohorte.mostrarEstado', [
            'programas'                 => $programasEducativos,
            'tamanioProgramas'          => count($programasEducativos),
            'cohorte'                   => $cohorte[0],
            'informacionPorPrograma'    => $informacionPorPrograma,
            'ultimoPeriodo'             => Periodo::where('IdPeriodo', '=', $ultimoPeriodo)->value('NombrePeriodo')
        ]);
    }

    public function mostrarEgresados($nombreCohorte)
    {
        $cohorte                = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->get();
        $programasEducativos    = ProgramaEducativo::get();
        $gruposPorPrograma      = $this->clasificarGrupos($cohorte);
        $informacion            = $this->getDatosEgresados($gruposPorPrograma);
        $informacionPorPrograma = $informacion['informacionPorPrograma'];
        $ultimoPeriodo          = $informacion['ultimoPeriodo'];
        $periodoInicio          = $informacion['periodoInicio'];
        $periodos           = Periodo::whereBetween('IdPeriodo', array($periodoInicio, $periodoInicio + 4))->get();
        $modalidades        = Modalidad::where('TipoModalidad', '=', 'Titulación')->get();
        return view('cohorte.mostrarEgresados', [
            'programas'                 => $programasEducativos,
            'tamanioProgramas'          => count($programasEducativos),
            'cohorte'                   => $cohorte[0],
            'informacionPorPrograma'    => $informacionPorPrograma,
            'modalidades'       => $modalidades,
            'periodos'          => $periodos,
            'totalPeriodos'     => $periodos->count(),
            'totalModalidades'  => $modalidades->count(),
            'ultimoPeriodo'     => Periodo::where('IdPeriodo', '=', $ultimoPeriodo)->value('NombrePeriodo'),
        ]);
    }

    public function mostrarEgresadosPeriodo($nombreCohorte, $nombreGrupo, $nombrePeriodo)
    {
        $periodo            = Periodo::where('NombrePeriodo', '=', $nombrePeriodo)->get()->last();
        $idCohorte          = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->value('IdCohorte');
        $idGrupo            = Grupo::where("NombreGrupo", '=', $nombreGrupo)->where('IdCohorte', '=', $idCohorte)->value('IdGrupo');
        $alumnos            = Grupo_Estudiante::where('Estado', '=', 'Egresado')->where('IdGrupo', '=', $idGrupo)->get();
        $estudiantes        = [];
        foreach ($alumnos as $alumno) {
            $titulacion     = Titulacion::where('IdTrayectoria', '=', $alumno->IdTrayectoria)->get()->last();
            if ($titulacion->IdPeriodoEgreso == $periodo->IdPeriodo) {
                $estudiantes[] = $titulacion;
            }
        }
        $grupo              = Grupo::where('IdGrupo', '=', $idGrupo)->get();
        $periodos           = Periodo::where('NombrePeriodo', '=', $nombrePeriodo)->get();
        $modalidades        = Modalidad::where('TipoModalidad', '=', 'Titulación')->get();

        return view('grupos.mostrarEgresadosPeriodo', [
            'grupos'            => $grupo,
            'estudiantes'       => $estudiantes,
            'modalidades'       => $modalidades,
            'periodos'          => $periodos,
        ]);
    }

    public function mostrarTraslados($nombreCohorte)
    {
        $cohorte                = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->get();
        $programasEducativos    = ProgramaEducativo::get();
        $gruposPorPrograma      = $this->clasificarGrupos($cohorte);
        $informacion            = $this->getDatosTraslados($gruposPorPrograma);
        $informacionPorPrograma = $informacion['informacionPorPrograma'];
        $ultimoPeriodo          = $informacion['ultimoPeriodo'];

        return view('cohorte.mostrarTraslados', [
            'programas'                 => $programasEducativos,
            'tamanioProgramas'          => count($programasEducativos),
            'cohorte'                   => $cohorte[0],
            'informacionPorPrograma'    => $informacionPorPrograma,
            'ultimoPeriodo'     => Periodo::where('IdPeriodo', '=', $ultimoPeriodo)->value('NombrePeriodo'),
        ]);
    }

    public function mostrarReprobados($nombreCohorte)
    {
        $cohorte                = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->get();
        $programasEducativos    = ProgramaEducativo::get();
        $gruposPorPrograma      = $this->clasificarGrupos($cohorte);
        $informacion            = $this->getDatosReprobados($gruposPorPrograma);
        $informacionPorPrograma = $informacion['informacionPorPrograma'];
        $ultimoPeriodo          = $informacion['ultimoPeriodo'];
        $periodoInicio          = $informacion['periodoInicio'];
        $periodos           = Periodo::whereBetween('IdPeriodo', array($periodoInicio, $periodoInicio + 12))->get();
        return view('cohorte.mostrarReprobados', [
            'programas'                 => $programasEducativos,
            'tamanioProgramas'          => count($programasEducativos),
            'cohorte'                   => $cohorte[0],
            'informacionPorPrograma'    => $informacionPorPrograma,
            'periodos'          => $periodos,
            'totalPeriodos'     => $periodos->count(),
            'ultimoPeriodo'     => Periodo::where('IdPeriodo', '=', $ultimoPeriodo)->value('NombrePeriodo'),
        ]);
    }

    public function mostrarReprobadosPeriodo($nombreCohorte, $nombreGrupo, $nombrePeriodo)
    {
        $periodo            = Periodo::where('NombrePeriodo', '=', $nombrePeriodo)->get()->last();
        $idCohorte          = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->value('IdCohorte');
        $idGrupo            = Grupo::where("NombreGrupo", '=', $nombreGrupo)->where('IdCohorte', '=', $idCohorte)->value('IdGrupo');
        $alumnos            = Grupo_Estudiante::where('IdGrupo', '=', $idGrupo)->get();
        $estudiantes        = [];
        foreach ($alumnos as $alumno) {
            $reprobado      = Reprobado::where('IdTrayectoria', '=', $alumno->IdTrayectoria)->get()->last();
            if ($reprobado != null && $reprobado->IdPeriodo == $periodo->IdPeriodo) {
                $estudiantes[] = $reprobado;
            }
        }
        $grupo              = Grupo::where('IdGrupo', '=', $idGrupo)->get();
        $periodos           = Periodo::where('NombrePeriodo', '=', $nombrePeriodo)->get();
        $modalidades        = Modalidad::where('TipoModalidad', '=', 'Titulación')->get();

        return view('grupos.mostrarReprobadosPeriodo', [
            'grupos'            => $grupo,
            'estudiantes'       => $estudiantes,
            'modalidades'       => $modalidades,
            'periodos'          => $periodos,
            
        ]);
    }


    public function mostrarBajas($nombreCohorte)
    {
        $cohorte                = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->get();
        $programasEducativos    = ProgramaEducativo::get();
        $gruposPorPrograma      = $this->clasificarGrupos($cohorte);
        $informacion            = $this->getDatosBajas($gruposPorPrograma);
        $informacionPorPrograma = $informacion['informacionPorPrograma'];
        $ultimoPeriodo          = $informacion['ultimoPeriodo'];
        $periodoInicio          = $informacion['periodoInicio'];
        return view('cohorte.mostrarBajas', [
            'programas'                 => $programasEducativos,
            'tamanioProgramas'          => count($programasEducativos),
            'cohorte'                   => $cohorte[0],
            'informacionPorPrograma'    => $informacionPorPrograma,
            'ultimoPeriodo'     => Periodo::where('IdPeriodo', '=', $ultimoPeriodo)->value('NombrePeriodo'),
        ]);
    }

    //<---- Métodos auxiliares ---->

    private function clasificarGrupos($cohorte)
    {
        $grupos                 = Grupo::orderBy('IdProgramaEducativo', 'ASC')
            ->where('IdCohorte', '=', $cohorte[0]->IdCohorte)
            ->get();
        $programasEducativos    = ProgramaEducativo::get();
        $gruposPorPrograma      = [];
        $gruposTemporal         = [];
        $contador = 0;
        $contador2 = 0;
        foreach ($programasEducativos as $programa) {
            foreach ($grupos as $clave => $grupo) {
                if ($grupo->IdProgramaEducativo == $programa->IdProgramaEducativo) {
                    $gruposTemporal[$contador2] = $grupo->IdGrupo;
                    unset($grupos[$clave]);
                }
                $contador2++;
            }
            $gruposPorPrograma[$contador] = $gruposTemporal;
            $gruposTemporal     = [];
            $contador2          = 0;
            $contador++;
        }
        return $gruposPorPrograma;
    }

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
            $cantidades[$contador] = ['hombre' => $hombres, 'mujer' => $mujeres, 'total' => $hombres + $mujeres];
            $hombres = 0;
            $mujeres = 0;
            $contador++;
        }
        return $cantidades;
    }

    private function getReprobadosPorPeriodo($estudiantes, $idGrupo)
    {
        $grupo              = Grupo::where('IdGrupo', '=', $idGrupo)->get()->last();
        $periodoInicio      = $grupo->IdPeriodoInicio - 1;
        $periodos           = Periodo::whereBetween('IdPeriodo', array($periodoInicio, $periodoInicio + 12))->get();
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
            $cantidades[$contador] = ['hombre' => $hombres, 'mujer' => $mujeres, 'total' => $hombres + $mujeres];
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
            $cantidades[$contador] = ['hombre' => $hombres, 'mujer' => $mujeres, 'total' => $hombres + $mujeres];
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

    private function getDatosResumen($gruposPorPrograma)
    {

        $informacionPorPrograma = [];
        $contador               = 0;
        $activoHombre           = 0;
        $activoMujer            = 0;
        $totalActivos           = 0;
        $egresadoHombre         = 0;
        $egresadoMujer          = 0;
        $totalEgresados         = 0;
        $entranteHombre         = 0;
        $entranteMujer          = 0;
        $totalEntrantes         = 0;
        $salienteHombre         = 0;
        $salienteMujer          = 0;
        $totalSalientes         = 0;
        $bajaHombre             = 0;
        $bajaMujer              = 0;
        $totalBajas             = 0;
        $ultimoPeriodo          = 0;

        foreach ($gruposPorPrograma as $gruposAuxiliares) {
            foreach ($gruposAuxiliares as $grupoAuxiliar) {
                $estudiantes    = DB::table('Grupo_Estudiante')
                    ->where('Estado', '=', 'Activo')
                    ->where('TipoTraslado', '=', null)
                    ->where('IdGrupo', '=', $grupoAuxiliar)
                    ->get();
                $resultados     = $this->getCantidadesGenero($estudiantes);
                $activoHombre   = $activoHombre + $resultados[0];
                $activoMujer    = $activoMujer + $resultados[1];
                $totalActivos   = $totalActivos + $activoHombre + $activoMujer;
                $estudiantes    = DB::table('Grupo_Estudiante')
                    ->where('Estado', '=', 'Egresado')
                    ->where('IdGrupo', '=', $grupoAuxiliar)
                    ->get();

                $resultados     = $this->getCantidadesGenero($estudiantes);
                $egresadoHombre = $egresadoHombre + $resultados[0];
                $egresadoMujer  = $egresadoMujer +  $resultados[1];
                $totalEgresados = $totalEgresados + $egresadoHombre + $egresadoMujer;

                $estudiantes    = DB::table('Grupo_Estudiante')
                    ->where('Estado', '=', 'Activo')
                    ->where('TipoTraslado', '=', 'Entrante')
                    ->where('IdGrupo', '=', $grupoAuxiliar)
                    ->get();

                $resultados     = $this->getCantidadesGenero($estudiantes);
                $entranteHombre = $entranteHombre + $resultados[0];
                $entranteMujer  = $entranteMujer  + $resultados[1];
                $totalEntrantes = $totalEntrantes + $entranteHombre + $entranteMujer;

                $estudiantes = DB::table('Grupo_Estudiante')
                    ->where('Estado', '=', 'Activo')
                    ->where('TipoTraslado', '=', 'Saliente')
                    ->where('IdGrupo', '=', $grupoAuxiliar)
                    ->get();

                $resultados     = $this->getCantidadesGenero($estudiantes);
                $salienteHombre = $salienteHombre + $resultados[0];
                $salienteMujer  = $salienteMujer + $resultados[1];
                $totalSalientes = $totalSalientes + $salienteHombre + $salienteMujer;

                $estudiantes = DB::table('Grupo_Estudiante')
                    ->where('Estado', '=', 'Baja')
                    ->where('IdGrupo', '=', $grupoAuxiliar)
                    ->get();

                $resultados     = $this->getCantidadesGenero($estudiantes);
                $bajaHombre     = $bajaHombre + $resultados[0];
                $bajaMujer      = $bajaMujer + $resultados[1];
                $totalBajas     = $totalBajas + $bajaHombre + $bajaMujer;

                $idUltimoPeriodo = Grupo::where('IdGrupo', '=', $grupoAuxiliar)->value('IdPeriodoActivo');
                if ($idUltimoPeriodo > $ultimoPeriodo) {
                    $ultimoPeriodo = $idUltimoPeriodo;
                }
            }

            $informacionPorPrograma[$contador] = [
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

            $activoHombre           = 0;
            $activoMujer            = 0;
            $totalActivos           = 0;
            $egresadoHombre         = 0;
            $egresadoMujer          = 0;
            $totalEgresados         = 0;
            $entranteHombre         = 0;
            $entranteMujer          = 0;
            $totalEntrantes         = 0;
            $salienteHombre         = 0;
            $salienteMujer          = 0;
            $totalSalientes         = 0;
            $bajaHombre             = 0;
            $bajaMujer              = 0;
            $totalBajas             = 0;

            $contador++;
        }
        return ['informacionPorPrograma' => $informacionPorPrograma, 'ultimoPeriodo' => $ultimoPeriodo];
    }

    private function getDatosEstado($gruposPorPrograma)
    {
        $informacionPorPrograma = [];
        $contador               = 0;
        $activoHombre           = 0;
        $activoMujer            = 0;
        $totalActivos           = 0;
        $egresadoHombre         = 0;
        $egresadoMujer          = 0;
        $totalEgresados         = 0;
        $bajaHombre             = 0;
        $bajaMujer              = 0;
        $totalBajas             = 0;
        $ultimoPeriodo          = 0;

        foreach ($gruposPorPrograma as $gruposAuxiliares) {
            foreach ($gruposAuxiliares as $grupoAuxiliar) {

                $estudiantes = DB::table('Grupo_Estudiante')
                    ->where('Estado', '=', 'Activo')
                    ->where('IdGrupo', '=', $grupoAuxiliar)
                    ->get();

                $resultados = $this->getCantidadesGenero($estudiantes);
                $activoHombre   = $activoHombre + $resultados[0];
                $activoMujer    = $activoMujer + $resultados[1];
                $totalActivos   = $totalActivos + $activoHombre + $activoMujer;

                $estudiantes = DB::table('Grupo_Estudiante')
                    ->where('Estado', '=', 'Egresado')
                    ->where('IdGrupo', '=', $grupoAuxiliar)
                    ->get();

                $resultados     = $this->getCantidadesGenero($estudiantes);
                $egresadoHombre = $egresadoHombre + $resultados[0];
                $egresadoMujer  = $egresadoMujer +  $resultados[1];
                $totalEgresados = $totalEgresados + $egresadoHombre + $egresadoMujer;

                $estudiantes = DB::table('Grupo_Estudiante')
                    ->where('Estado', '=', 'Baja')
                    ->where('IdGrupo', '=', $grupoAuxiliar)
                    ->get();

                $resultados     = $this->getCantidadesGenero($estudiantes);
                $bajaHombre     = $bajaHombre + $resultados[0];
                $bajaMujer      = $bajaMujer + $resultados[1];
                $totalBajas     = $totalBajas + $bajaHombre + $bajaMujer;

                $idUltimoPeriodo = Grupo::where('IdGrupo', '=', $grupoAuxiliar)->value('IdPeriodoActivo');
                if ($idUltimoPeriodo > $ultimoPeriodo) {
                    $ultimoPeriodo = $idUltimoPeriodo;
                }
            }

            $informacionPorPrograma[$contador] = [
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

            $activoHombre           = 0;
            $activoMujer            = 0;
            $totalActivos           = 0;
            $egresadoHombre         = 0;
            $egresadoMujer          = 0;
            $totalEgresados         = 0;
            $bajaHombre             = 0;
            $bajaMujer              = 0;
            $totalBajas             = 0;

            $contador++;
        }
        return ['informacionPorPrograma' => $informacionPorPrograma, 'ultimoPeriodo' => $ultimoPeriodo];
    }


    private function getDatosEgresados($gruposPorPrograma)
    {
        $periodoInicio          = 0;
        $ultimoPeriodo          = 0;
        $informacionPorPrograma = [];
        $contador               = 0;
        $contador2              = 0;
        $egresadoHombre         = 0;
        $egresadoMujer          = 0;
        $totalEgresados         = 0;
        $cantidadesAuxiliares   = [];
        $cantidadesAuxiliares2  = [];
        $cantidadesPeriodos     = [];
        $cantidadesModalidad    = [];
        foreach ($gruposPorPrograma as $gruposAuxiliares) {
            foreach ($gruposAuxiliares as $grupoAuxiliar) {
                $estudiantes = DB::table('Grupo_Estudiante')
                    ->where('Estado', '=', 'Egresado')
                    ->where('IdGrupo', '=', $grupoAuxiliar)
                    ->get();
                $resultados     = $this->getCantidadesGenero($estudiantes);
                $egresadoHombre = $egresadoHombre + $resultados[0];
                $egresadoMujer  = $egresadoMujer +  $resultados[1];
                $totalEgresados = $totalEgresados + $egresadoHombre + $egresadoMujer;
                $cantidadesAuxiliares = $this->getEstudiantesPorPeriodo($estudiantes, $grupoAuxiliar);
                foreach ($cantidadesAuxiliares as $cantidades) {
                    if (empty($cantidadesPeriodos[$contador2])) {
                        $cantidadesPeriodos[$contador2] = ['hombre' => $cantidades["hombre"], 'mujer' => $cantidades["mujer"], 'total' => $cantidades["total"]];
                    } else {
                        $cantidadesPeriodos[$contador2]["hombre"]   = $cantidadesPeriodos[$contador2]["hombre"] + $cantidades["hombre"];
                        $cantidadesPeriodos[$contador2]["mujer"]    = $cantidadesPeriodos[$contador2]["mujer"] + $cantidades["mujer"];
                        $cantidadesPeriodos[$contador2]["total"]    = $cantidadesPeriodos[$contador2]["total"] + $cantidades["total"];
                    }
                    $contador2++;
                }
                $contador2 = 0;
                $contador3 = 0;
                $estudiantes = DB::table('Grupo_Estudiante')
                    ->where('Estado', '=', 'Egresado')
                    ->where('IdGrupo', '=', $grupoAuxiliar)
                    ->get();
                $cantidadesAuxiliares2 = $this->getEstudiantesPorModalidad($estudiantes);
                foreach ($cantidadesAuxiliares2 as $cantidades2) {
                    if (empty($cantidadesModalidad[$contador3])) {
                        $cantidadesModalidad[$contador3] = ['hombre' => $cantidades2["hombre"], 'mujer' => $cantidades2["mujer"], 'total' => $cantidades2["total"]];
                    } else {
                        $cantidadesModalidad[$contador3]["hombre"]   = $cantidadesModalidad[$contador3]["hombre"] + $cantidades2["hombre"];
                        $cantidadesModalidad[$contador3]["mujer"]    = $cantidadesModalidad[$contador3]["mujer"] + $cantidades2["mujer"];
                        $cantidadesModalidad[$contador3]["total"]    = $cantidadesModalidad[$contador3]["total"] + $cantidades2["total"];
                    }
                    $contador3++;
                }
                if ($periodoInicio == 0) {
                    $periodoInicio = Grupo::where('IdGrupo', '=', $grupoAuxiliar)->value('IdPeriodoInicio') + 7;
                }
                $idUltimoPeriodo = Grupo::where('IdGrupo', '=', $grupoAuxiliar)->value('IdPeriodoActivo');
                if ($idUltimoPeriodo > $ultimoPeriodo) {
                    $ultimoPeriodo = $idUltimoPeriodo;
                }
            }
            $informacionPorPrograma[$contador] = [
                'egresadoHombre'        => $egresadoHombre,
                'egresadoMujer'         => $egresadoMujer,
                'totalEgresados'        => $totalEgresados,
                'egresadosPorPeriodo'   => $cantidadesPeriodos,
                'egresadosPorModalidad' => $cantidadesModalidad,

            ];
            $egresadoHombre         = 0;
            $egresadoMujer          = 0;
            $totalEgresados         = 0;
            $cantidadesPeriodos     = [];
            $cantidadesModalidad    = [];
            $cantidadesAuxiliares   = [];
            $cantidadesAuxiliares2  = [];
            $contador++;
        }
        return ['informacionPorPrograma' => $informacionPorPrograma, 'ultimoPeriodo' => $ultimoPeriodo, 'periodoInicio' => $periodoInicio];
    }

    private function getDatosTraslados($gruposPorPrograma)
    {
        $ultimoPeriodo          = 0;
        $informacionPorPrograma = [];
        $contador               = 0;
        $estudiantesSalientes   = [];
        $salienteHombre         = 0;
        $salienteMujer          = 0;
        $totalSalientes         = 0;
        $estudiantesEntrantes   = [];
        $entranteHombre         = 0;
        $entranteMujer          = 0;
        $totalEntrantes         = 0;
        foreach ($gruposPorPrograma as $gruposAuxiliares) {
            foreach ($gruposAuxiliares as $grupoAuxiliar) {
                $estudiantes = DB::table('Grupo_Estudiante')
                    ->where('TipoTraslado', '<>', 'null')
                    ->where('IdGrupo', '=', $grupoAuxiliar)
                    ->get();
                foreach ($estudiantes as $estudiante) {
                    if ($estudiante->TipoTraslado == 'Entrante') {
                        $estudiantesEntrantes[] = $estudiante;
                    } elseif ($estudiante->TipoTraslado == 'Saliente') {
                        $estudiantesSalientes[] = $estudiante;
                    }
                }

                $resultadosEntrantes     = $this->getCantidadesGenero($estudiantesEntrantes);
                $entranteHombre = $entranteHombre + $resultadosEntrantes[0];
                $entranteMujer  = $entranteMujer +  $resultadosEntrantes[1];
                $totalEntrantes = $totalEntrantes + $entranteHombre + $entranteMujer;

                $resultadosSalientes     = $this->getCantidadesGenero($estudiantesSalientes);
                $salienteHombre = $salienteHombre + $resultadosSalientes[0];
                $salienteMujer  = $salienteMujer +  $resultadosSalientes[1];
                $totalSalientes = $totalSalientes + $salienteHombre + $salienteMujer;

                $idUltimoPeriodo = Grupo::where('IdGrupo', '=', $grupoAuxiliar)->value('IdPeriodoActivo');
                if ($idUltimoPeriodo > $ultimoPeriodo) {
                    $ultimoPeriodo = $idUltimoPeriodo;
                }
            }
            $informacionPorPrograma[$contador] = [
                'entrantes'        => ['hombre' => $entranteHombre, 'mujer' => $entranteMujer, 'total' => $totalEntrantes],
                'salientes'        => ['hombre' => $salienteHombre, 'mujer' => $salienteMujer, 'total' => $totalSalientes]
            ];

            $entranteHombre         = 0;
            $entranteMujer          = 0;
            $totalEntrantes         = 0;
            $salienteHombre         = 0;
            $salienteMujer          = 0;
            $totalSalientes         = 0;
            $estudiantesEntrantes   = [];
            $estudiantesSalientes   = [];
            $contador++;
        }
        return ['informacionPorPrograma' => $informacionPorPrograma, 'ultimoPeriodo' => $ultimoPeriodo];
    }

    private function getDatosReprobados($gruposPorPrograma)
    {
        $periodoInicio          = 0;
        $ultimoPeriodo          = 0;
        $informacionPorPrograma = [];
        $contador               = 0;
        $contador2              = 0;
        $reprobadoHombre        = 0;
        $reprobadoMujer         = 0;
        $totalReprobados        = 0;
        $cantidadesAuxiliares   = [];
        $cantidadesPeriodos     = [];

        foreach ($gruposPorPrograma as $gruposAuxiliares) {
            foreach ($gruposAuxiliares as $grupoAuxiliar) {
                $estudiantes = DB::table('Grupo_Estudiante')
                    ->where('IdGrupo', '=', $grupoAuxiliar)
                    ->get();
                foreach ($estudiantes as $clave => $estudiante) {
                    $reprobado = Reprobado::where('IdTrayectoria', '=', $estudiante->IdTrayectoria)->get()->last();
                    if ($reprobado == null) {
                        unset($estudiantes[$clave]);
                    }
                }
                $resultados     = $this->getCantidadesGenero($estudiantes);
                $reprobadoHombre = $reprobadoHombre + $resultados[0];
                $reprobadoMujer  = $reprobadoMujer +  $resultados[1];
                $totalReprobados = $totalReprobados + $reprobadoHombre + $reprobadoMujer;

                $cantidadesAuxiliares = $this->getReprobadosPorPeriodo($estudiantes, $grupoAuxiliar);
                foreach ($cantidadesAuxiliares as $cantidades) {
                    if (empty($cantidadesPeriodos[$contador2])) {
                        $cantidadesPeriodos[$contador2] = ['hombre' => $cantidades["hombre"], 'mujer' => $cantidades["mujer"], 'total' => $cantidades["total"]];
                    } else {
                        $cantidadesPeriodos[$contador2]["hombre"]   = $cantidadesPeriodos[$contador2]["hombre"] + $cantidades["hombre"];
                        $cantidadesPeriodos[$contador2]["mujer"]    = $cantidadesPeriodos[$contador2]["mujer"] + $cantidades["mujer"];
                        $cantidadesPeriodos[$contador2]["total"]    = $cantidadesPeriodos[$contador2]["total"] + $cantidades["total"];
                    }
                    $contador2++;
                }
                $contador2 = 0;
                if ($periodoInicio == 0) {
                    $periodoInicio = Grupo::where('IdGrupo', '=', $grupoAuxiliar)->value('IdPeriodoInicio');
                }
                $idUltimoPeriodo = Grupo::where('IdGrupo', '=', $grupoAuxiliar)->value('IdPeriodoActivo');
                if ($idUltimoPeriodo > $ultimoPeriodo) {
                    $ultimoPeriodo = $idUltimoPeriodo;
                }
            }
            $informacionPorPrograma[$contador] = [
                'reprobadoHombre'        => $reprobadoHombre,
                'reprobadoMujer'         => $reprobadoMujer,
                'totalReprobados'        => $totalReprobados,
                'egresadosPorPeriodo'   => $cantidadesPeriodos,
            ];
            $reprobadoHombre         = 0;
            $reprobadoMujer          = 0;
            $totalReprobados         = 0;
            $cantidadesPeriodos     = [];
            $cantidadesAuxiliares   = [];
            $contador++;
        }
        return ['informacionPorPrograma' => $informacionPorPrograma, 'ultimoPeriodo' => $ultimoPeriodo, 'periodoInicio' => $periodoInicio];
    }

    private function getDatosBajas($gruposPorPrograma)
    {
        $periodoInicio          = 0;
        $ultimoPeriodo          = 0;
        $informacionPorPrograma = [];
        $contador               = 0;
        $estudiantesDefinitivos = [];
        $definitivoHombre       = 0;
        $definitivoMujer        = 0;
        $totalDefinitivos       = 0;
        $estudiantesTemporales  = [];
        $temporalHombre         = 0;
        $temporalMujer          = 0;
        $totalTemporales        = 0;

        foreach ($gruposPorPrograma as $gruposAuxiliares) {
            foreach ($gruposAuxiliares as $grupoAuxiliar) {
                $estudiantes = DB::table('Grupo_Estudiante')
                    ->where('Estado', '=', 'Baja')
                    ->where('IdGrupo', '=', $grupoAuxiliar)
                    ->get();
                foreach ($estudiantes as $estudiante) {
                    $baja = Baja::where('IdTrayectoria', '=', $estudiante->IdTrayectoria)->get()->last();
                    if ($baja->TipoBaja == 'Temporal') {
                        $estudiantesTemporales[] = $baja;
                    } elseif ($baja->TipoBaja == 'Definitiva') {
                        $estudiantesDefinitivos[] = $baja;
                    }
                }

                $resultadosTemporales    = $this->getCantidadesGenero($estudiantesTemporales);
                $temporalHombre         = $temporalHombre + $resultadosTemporales[0];
                $temporalMujer          = $temporalMujer +  $resultadosTemporales[1];
                $totalTemporales        = $totalTemporales + $temporalHombre + $temporalMujer;

                $resultadosDefinitivos     = $this->getCantidadesGenero($estudiantesDefinitivos);
                $definitivoHombre = $definitivoHombre + $resultadosDefinitivos[0];
                $definitivoMujer  = $definitivoMujer +  $resultadosDefinitivos[1];
                $totalDefinitivos = $totalDefinitivos + $definitivoHombre + $definitivoMujer;

                if ($periodoInicio == 0) {
                    $periodoInicio = Grupo::where('IdGrupo', '=', $grupoAuxiliar)->value('IdPeriodoInicio');
                }
                $idUltimoPeriodo = Grupo::where('IdGrupo', '=', $grupoAuxiliar)->value('IdPeriodoActivo');
                if ($idUltimoPeriodo > $ultimoPeriodo) {
                    $ultimoPeriodo = $idUltimoPeriodo;
                }
            }
            $informacionPorPrograma[$contador] = [
                'temporal'        => ['hombre' => $temporalHombre, 'mujer' => $temporalMujer, 'total' => $totalTemporales],
                'definitivo'        => ['hombre' => $definitivoHombre, 'mujer' => $definitivoMujer, 'total' => $totalDefinitivos]
            ];
            
            $estudiantesDefinitivos = [];
            $definitivoHombre       = 0;
            $definitivoMujer        = 0;
            $totalDefinitivos       = 0;
            $estudiantesTemporales  = [];
            $temporalHombre         = 0;
            $temporalMujer          = 0;
            $totalTemporales        = 0;
            $contador++;
        }
        return ['informacionPorPrograma' => $informacionPorPrograma, 'ultimoPeriodo' => $ultimoPeriodo, 'periodoInicio' => $periodoInicio];
    }

    //<---- Métodos Para imprimir tablas ---->

    public function imprimirResumen($nombreCohorte)
    {
        $cohorte                = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->get();
        $programasEducativos    = ProgramaEducativo::get();

        $gruposPorPrograma      = $this->clasificarGrupos($cohorte);
        $informacion            = $this->getDatosResumen($gruposPorPrograma);
        $informacionPorPrograma = $informacion['informacionPorPrograma'];
        $ultimoPeriodo          = $informacion['ultimoPeriodo'];

        $pdf = PDF::loadView('cohorte.pdf.imprimirResumen', [
            'programas'                 => $programasEducativos,
            'tamanioProgramas'          => count($programasEducativos),
            'cohorte'                   => $cohorte[0],
            'informacionPorPrograma'    => $informacionPorPrograma,
            'fecha'                     => Carbon::now()->format('j/m/Y'),
            'hora'                      => Carbon::now()->format('h:i:s A'),
            'ultimoPeriodo'             => Periodo::where('IdPeriodo', '=', $ultimoPeriodo)->value('NombrePeriodo')
        ]);
        return $pdf->stream('Resumen_Cohorte_' . $nombreCohorte . '.pdf');
    }

    public function imprimirEstado($nombreCohorte)
    {
        $cohorte                = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->get();
        $programasEducativos    = ProgramaEducativo::get();
        $gruposPorPrograma      = $this->clasificarGrupos($cohorte);
        $informacion            = $this->getDatosEstado($gruposPorPrograma);
        $informacionPorPrograma = $informacion['informacionPorPrograma'];
        $ultimoPeriodo          = $informacion['ultimoPeriodo'];

        $pdf = PDF::loadView('cohorte.pdf.imprimirEstado', [
            'programas'                 => $programasEducativos,
            'tamanioProgramas'          => count($programasEducativos),
            'cohorte'                   => $cohorte[0],
            'informacionPorPrograma'    => $informacionPorPrograma,
            'ultimoPeriodo'             => Periodo::where('IdPeriodo', '=', $ultimoPeriodo)->value('NombrePeriodo'),
            'fecha'                     => Carbon::now()->format('j/m/Y'),
            'hora'                      => Carbon::now()->format('h:i:s A'),
        ]);
        return $pdf->stream('Estado_Cohorte_' . $nombreCohorte . '.pdf');
    }

    public function imprimirEgresados($nombreCohorte)
    {
        $cohorte                = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->get();
        $programasEducativos    = ProgramaEducativo::get();
        $gruposPorPrograma      = $this->clasificarGrupos($cohorte);
        $informacion            = $this->getDatosEgresados($gruposPorPrograma);
        $informacionPorPrograma = $informacion['informacionPorPrograma'];
        $ultimoPeriodo          = $informacion['ultimoPeriodo'];
        $periodoInicio          = $informacion['periodoInicio'];
        $periodos           = Periodo::whereBetween('IdPeriodo', array($periodoInicio, $periodoInicio + 4))->get();
        $modalidades        = Modalidad::where('TipoModalidad', '=', 'Titulación')->get();
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('cohorte.pdf.imprimirEgresados', [
            'programas'                 => $programasEducativos,
            'tamanioProgramas'          => count($programasEducativos),
            'cohorte'                   => $cohorte[0],
            'informacionPorPrograma'    => $informacionPorPrograma,
            'modalidades'       => $modalidades,
            'periodos'          => $periodos,
            'totalPeriodos'     => $periodos->count(),
            'totalModalidades'  => $modalidades->count(),
            'ultimoPeriodo'     => Periodo::where('IdPeriodo', '=', $ultimoPeriodo)->value('NombrePeriodo'),
            'fecha'                     => Carbon::now()->format('j/m/Y'),
            'hora'                      => Carbon::now()->format('h:i:s A'),
        ]);
        return $pdf->stream('Egresados_' . $nombreCohorte . '.pdf');
    }

    public function imprimirTraslados($nombreCohorte)
    {
        $cohorte                = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->get();
        $programasEducativos    = ProgramaEducativo::get();
        $gruposPorPrograma      = $this->clasificarGrupos($cohorte);
        $informacion            = $this->getDatosTraslados($gruposPorPrograma);
        $informacionPorPrograma = $informacion['informacionPorPrograma'];
        $ultimoPeriodo          = $informacion['ultimoPeriodo'];

        $pdf = PDF::loadView('cohorte.pdf.imprimirTraslados', [
            'programas'                 => $programasEducativos,
            'tamanioProgramas'          => count($programasEducativos),
            'cohorte'                   => $cohorte[0],
            'informacionPorPrograma'    => $informacionPorPrograma,
            'ultimoPeriodo'     => Periodo::where('IdPeriodo', '=', $ultimoPeriodo)->value('NombrePeriodo'),
            'fecha'                     => Carbon::now()->format('j/m/Y'),
            'hora'                      => Carbon::now()->format('h:i:s A'),

        ]);
        return $pdf->stream('Traslados_' . $nombreCohorte . '.pdf');
    }

    public function imprimirReprobados($nombreCohorte)
    {
        $cohorte                = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->get();
        $programasEducativos    = ProgramaEducativo::get();
        $gruposPorPrograma      = $this->clasificarGrupos($cohorte);
        $informacion            = $this->getDatosReprobados($gruposPorPrograma);
        $informacionPorPrograma = $informacion['informacionPorPrograma'];
        $ultimoPeriodo          = $informacion['ultimoPeriodo'];
        $periodoInicio          = $informacion['periodoInicio'];
        $periodos           = Periodo::whereBetween('IdPeriodo', array($periodoInicio, $periodoInicio + 12))->get();
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('cohorte.pdf.imprimirReprobados', [
            'programas'                 => $programasEducativos,
            'tamanioProgramas'          => count($programasEducativos),
            'cohorte'                   => $cohorte[0],
            'informacionPorPrograma'    => $informacionPorPrograma,
            'periodos'          => $periodos,
            'totalPeriodos'     => $periodos->count(),
            'ultimoPeriodo'     => Periodo::where('IdPeriodo', '=', $ultimoPeriodo)->value('NombrePeriodo'),
            'fecha'                     => Carbon::now()->format('j/m/Y'),
            'hora'                      => Carbon::now()->format('h:i:s A'),
        ]);
        return $pdf->stream('Reprobados_' . $nombreCohorte . '.pdf');
    }




    public function imprimirBajas($nombreCohorte, $nombreGrupo)
    {
        $idCohorte              = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->value('IdCohorte');
        $idGrupo                = Grupo::where("NombreGrupo", '=', $nombreGrupo)->where('IdCohorte', '=', $idCohorte)->value('IdGrupo');
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
        $grupo                  = Grupo::where('IdGrupo', '=', $idGrupo)->get();
        $motivos                = Motivo::get();
        $bajasMotivos           = $this->getEstudiantesPorMotivo($estudiantes);

        $pdf = PDF::loadView('grupos.pdf.imprimirBajas', [
            'grupos'            => $grupo,
            'hombreTemporal'    => $hombreTemporal,
            'mujerTemporal'     => $mujerTemporal,
            'hombreDefinitivo'  => $hombreDefinitivo,
            'mujerDefinitivo'   => $mujerDefinitivo,
            'resultados'        => $bajasMotivos,
            'motivos'           => $motivos,
        ]);
        return $pdf->stream('Bajas_' . $nombreGrupo . '_' . $nombreCohorte . '.pdf');
    }
}
