<?php

namespace App\Http\Controllers;

use App\Http\Requests\GrupoRequest;
use App\Models\Baja;
use App\Models\Cohorte;
use App\Models\Estudiante;
use App\Models\Facultad;
use App\Models\Grupo;
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
        \Gate::authorize('havepermiso', 'estudiante-ver-todos-propio');

        $idFCA = Facultad::where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('IdFacultad');
        return view('grupos.index', [
            'grupos'    => Grupo::where('IdFacultad', '=', $idFCA)->get()
        ]);
    }

    public function create()
    {
        \Gate::authorize('havepermiso', 'estudiante-ver-todos-propio');

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
        \Gate::authorize('havepermiso', 'estudiante-crear');

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
        \Gate::authorize('havepermiso', 'estudiante-ver-propio');

        return view('grupos.show', compact('grupo'));
    }


    public function edit(Grupo $grupo)
    {
        \Gate::authorize('havepermiso', 'estudiante-ver-propio');

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
        \Gate::authorize('havepermiso', 'estudiante-editar-propio');

        $request->validated();

        $grupo->update($request->all());

        return redirect()->route('grupos.index');
    }

    public function destroy(Grupo $grupo)
    {
        \Gate::authorize('havepermiso', 'estudiante-eliminar-propio');

        $ocupado = $this->contarEstudiantes($grupo->IdGrupo);
        if ($ocupado > 0) {
            Session::flash('flash', [['type' => "danger", 'message' => "El grupo '" . $grupo->NombreGrupo . "' ya está ocupado, no puede ser eliminado."]]);
            return redirect()->route('grupos.index');
        } else {
            try {
                $grupo->delete();
                Session::flash('flash', [['type' => "success", 'message' => "El grupo '" . $grupo->NombreGrupo . "' fue eliminado correctamente."]]);
                return redirect()->route('grupos.index');
            } catch (\Throwable $throwable) {
                Session::flash('flash', [['type' => "danger", 'message' => "El grupo '" . $grupo->NombreGrupo . "' NO pudo ser eliminado."]]);
                return redirect()->route('grupos.index');
            }
        }
    }


    //<---- Métodos auxiliares ---->

    public function contarEstudiantes($idGrupo)
    {
        $cantidadEstudiantes = Trayectoria::where('IdGrupo', $idGrupo)->count();
        return $cantidadEstudiantes;
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


 //<---- Funciones para visualizar las tablas resumen de los grupos ---->

    public function mostrarGrupo($nombreCohorte, $nombreGrupo)
    {
        return view('grupos.index', [
            'grupos'            => Grupo::all()
        ]);
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

}
