<?php

namespace App\Http\Controllers;

use App\Http\Requests\GrupoRequest;
use App\Models\Cohorte;
use App\Models\Facultad;
use App\Models\Grupo;
use App\Models\Grupo_Estudiante;
use App\Models\Modalidad;
use App\Models\Periodo;
use App\Models\ProgramaEducativo;
use App\Models\Titulacion;
use App\Models\Trayectoria;
use Illuminate\Http\Request;
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
        $idFCA = DB::table('Facultad')
            ->where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('IdFacultad');
        return view('grupos.create', [
            'grupos'        => new Grupo(),
            'periodos'      => Periodo::get(),
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
        $existe      = DB::table('Grupo')->where([
            ['NombreGrupo', '=', $request->NombreGrupo],
            ['IdProgramaEducativo', '=', $request->IdProgramaEducativo],
            ['IdCohorte', '=', $request->IdCohorte]
        ])->count();
        $programaLis = ProgramaEducativo::where("NombreProgramaEducativo", "=", "Licenciatura en Ingeniería de Software")->value('IdProgramaEducativo');
        if ($existe > 0) {
            Session::flash('flash', [['type' => "danger", 'message' => "El grupo " . $request->NombreGrupo . " ya fue registrado en ese cohorte."]]);
            return redirect()->route('grupos.index');
        }

        if ($request->IdProgramaEducativo == $programaLis) {
            $cohorteOcupado = DB::table('Grupo')->where([
                ['IdProgramaEducativo', '=', $programaLis],
                ['IdCohorte', '=', $request->IdCohorte]
            ])->count();
            if ($cohorteOcupado > 0) {
                $nombreCohorte = Cohorte::where("IdCohorte", "=", $request->IdCohorte)->value('NombreCohorte');
                Session::flash('flash', [['type' => "danger", 'message' => "El cohorte " . $nombreCohorte . " ya cuenta con un grupo de LIS registrado."]]);
                return redirect()->route('grupos.index');
            }
        }

        try {
            Grupo::create($request->validated());
            Session::flash('flash', [['type' => "success", 'message' => "Grupo creado correctamente."]]);
            return redirect()->route('grupos.index');
        } catch (\Throwable $throwable) {
            dd($throwable);
            Session::flash('flash', [['type' => "danger", 'message' => "El Grupo NO pudo ser creado."]]);
            return redirect()->route('grupos.create');
        }
    }

    public function show(Grupo $grupo)
    {
        $activos = Grupo_Estudiante::where("Estado", "=", "Activo")->count();
        $inactivos = Grupo_Estudiante::where("Estado", "<>", "Activo")->count();
        return view('grupos.show', [
            'grupos' => $grupo,
            'activos' => $activos,
            'inactivos' => $inactivos,
        ]);
    }


    public function edit(Grupo $grupo)
    {
        $idFCA = DB::table('Facultad')
            ->where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('IdFacultad');
        return view('grupos.edit', [
            'grupos'        => $grupo,
            'periodos'      => Periodo::get(),
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
            Session::flash('flash', [['type' => "danger", 'message' => "El grupo " . $request->NombreGrupo . " ya fue registrado en ese cohorte."]]);
            return redirect()->route('grupos.index');
        } else {
            $grupoOcupado = Grupo_Estudiante::where("IdGrupo", "=", $request->IdGrupo)->count();
            if ($grupoOcupado > 0) {
                Session::flash('flash', [['type' => "danger", 'message' => "El grupo " . $request->NombreGrupo . " ya está ocupado, no puede ser actualizado."]]);
                return redirect()->route('grupos.index');
            }
            try {
                $grupo->update($request->validated());
                Session::flash('flash', [['type' => "success", 'message' => "Grupo editado correctamente."]]);
                return redirect()->route('grupos.index');
            } catch (\Throwable $throwable) {
                Session::flash('flash', [['type' => "danger", 'message' => "El grupo NO pudo ser editado."]]);
                return redirect()->route('grupos.edit', $grupo);
            }
        }
    }

    public function destroy(Grupo $grupo)
    {
        $ocupado = Grupo_Estudiante::where('IdGrupo', $grupo->IdGrupo)->count();
        if ($ocupado > 0) {
            Session::flash('flash', [['type' => "danger", 'message' => "El grupo " . $grupo->NombreGrupo . " ya está ocupado, no puede ser eliminado."]]);
            return redirect()->route('grupos.index');
        } else {
            try {
                $grupo->forceDelete();
                Session::flash('flash', [['type' => "success", 'message' => "El grupo " . $grupo->NombreGrupo . " fue eliminado correctamente."]]);
                return redirect()->route('grupos.index');
            } catch (\Throwable $throwable) {
                Session::flash('flash', [['type' => "danger", 'message' => "El grupo " . $grupo->NombreGrupo . " NO pudo ser eliminado correctamente."]]);
                return redirect()->route('grupos.index');
            }
        }
    }

    private function getCantidades($estudiantes)
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

    private function getPeriodos($estudiantes)
    {
        $periodos   = Periodo::get();
        $cantidades = [$periodos->count()];
        $contador   = 0;
        $titulacion = "";
        foreach ($periodos as $periodo) {
            foreach ($estudiantes as $estudiante) {
                $titulacion = Titulacion::where('IdTrayectoria', '=', $estudiante->IdTrayectoria)->get()->last();
                if ($periodo->IdPeriodo == $titulacion->IdPeriodoEgreso) {
                    $idDatosPersonales = DB::table('Trayectoria')
                        ->where('IdTrayectoria', '=', $estudiante->IdTrayectoria)
                        ->value('IdDatosPersonales');
                    $genero = DB::table('DatosPersonales')
                        ->where('IdDatosPersonales', '=', $idDatosPersonales)
                        ->value('genero');
                    if ($genero == "Hombre") {
                        $cantidades[$contador] = [$cantidades[$contador] + 1];
                    } else if ($genero == "Mujer") {
                        $cantidades[$contador] = $cantidades[$contador] + 1;
                    }
                }
            }
            $contador++;
        }
        // dd($cantidades);
        return $cantidades;
    }


    public function mostrarGrupo($nombreCohorte, $nombreGrupo)
    {
        $idCohorte = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->value('IdCohorte');
        $idGrupo = Grupo::where('NombreGrupo', '=', $nombreGrupo)->where('IdCohorte', '=', $idCohorte)->value('IdGrupo');
        $estudiantes = DB::table('Grupo_Estudiante')
            ->where('Estado', '=', 'Activo')
            ->where('TipoTraslado', '=', null)
            ->where('IdGrupo', '=', $idGrupo)
            ->get();
        $resultados = $this->getCantidades($estudiantes);
        $activoHombre = $resultados[0];
        $activoMujer = $resultados[1];
        $totalActivos  = $activoHombre + $activoMujer;

        $estudiantes = DB::table('Grupo_Estudiante')
            ->where('Estado', '=', 'Egresado')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();

        $resultados = $this->getCantidades($estudiantes);
        $egresadoHombre = $resultados[0];
        $egresadoMujer = $resultados[1];
        $totalEgresados  = $egresadoHombre + $egresadoMujer;

        $estudiantes = DB::table('Grupo_Estudiante')
            ->where('Estado', '=', 'Activo')
            ->where('TipoTraslado', '=', 'Entrante')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();

        $resultados = $this->getCantidades($estudiantes);
        $entranteHombre = $resultados[0];
        $entranteMujer = $resultados[1];
        $totalEntrantes = $entranteHombre + $entranteMujer;

        $estudiantes = DB::table('Grupo_Estudiante')
            ->where('Estado', '=', 'Activo')
            ->where('TipoTraslado', '=', 'Saliente')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();

        $resultados     = $this->getCantidades($estudiantes);
        $salienteHombre = $resultados[0];
        $salienteMujer  = $resultados[1];
        $totalSalientes = $salienteHombre + $salienteMujer;

        $estudiantes = DB::table('Grupo_Estudiante')
            ->where('Estado', '=', 'Baja')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();

        $resultados = $this->getCantidades($estudiantes);
        $bajaHombre = $resultados[0];
        $bajaMujer = $resultados[1];
        $totalBajas  = $bajaHombre + $bajaMujer;

        return view('grupos.mostrarGrupo', [
            'grupos' => Grupo::where("IdGrupo", "=", $idGrupo)->get(),
            'activoHombre'  => $activoHombre,
            'activoMujer'   => $activoMujer,
            'totalActivos'  => $totalActivos,

            'egresadoHombre' => $egresadoHombre,
            'egresadoMujer'  => $egresadoMujer,
            'totalEgresados' => $totalEgresados,

            'entranteHombre' => $entranteHombre,
            'entranteMujer'  => $entranteMujer,
            'totalEntrantes' => $totalEntrantes,

            'salienteHombre' => $salienteHombre,
            'salienteMujer'  => $salienteMujer,
            'totalSalientes' => $totalSalientes,

            'bajaHombre' => $bajaHombre,
            'bajaMujer'  => $bajaMujer,
            'totalBajas' => $totalBajas,
        ]);
    }

    public function mostrarEstado($nombreCohorte, $nombreGrupo)
    {
        $idCohorte = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->value('IdCohorte');
        $idGrupo = Grupo::where("NombreGrupo", '=', $nombreGrupo)->where('IdCohorte', '=', $idCohorte)->value('IdGrupo');
        $estudiantes = DB::table('Grupo_Estudiante')
            ->where('Estado', '=', 'Activo')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();
        $resultados = $this->getCantidades($estudiantes);
        $activoHombre = $resultados[0];
        $activoMujer = $resultados[1];
        $totalActivos  = $activoHombre + $activoMujer;

        $estudiantes = DB::table('Grupo_Estudiante')
            ->where('Estado', '=', 'Egresado')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();

        $resultados = $this->getCantidades($estudiantes);
        $egresadoHombre = $resultados[0];
        $egresadoMujer = $resultados[1];
        $totalEgresados  = $egresadoHombre + $egresadoMujer;

        $estudiantes = DB::table('Grupo_Estudiante')
            ->where('Estado', '=', 'Baja')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();

        $resultados = $this->getCantidades($estudiantes);
        $bajaHombre = $resultados[0];
        $bajaMujer = $resultados[1];
        $totalBajas  = $bajaHombre + $bajaMujer;

        return view('grupos.mostrarEstado', [
            'grupos' => Grupo::where("IdGrupo", "=", $idGrupo)->get(),
            'activoHombre' => $activoHombre,
            'activoMujer' => $activoMujer,
            'totalActivos' => $totalActivos,

            'egresadoHombre' => $egresadoHombre,
            'egresadoMujer' => $egresadoMujer,
            'totalEgresados' => $totalEgresados,

            'bajaHombre' => $bajaHombre,
            'bajaMujer' => $bajaMujer,
            'totalBajas' => $totalBajas,
        ]);
    }

    public function mostrarEgresados($nombreCohorte, $nombreGrupo)
    {
        $idCohorte      = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->value('IdCohorte');
        $idGrupo        = Grupo::where("NombreGrupo", '=', $nombreGrupo)->where('IdCohorte', '=', $idCohorte)->value('IdGrupo');
        $estudiantes    = DB::table('Grupo_Estudiante')
            ->where('Estado', '=', 'Egresado')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();
        dd($estudiantes);
        $resultados     = $this->getCantidades($estudiantes);
        $activoHombre   = $resultados[0];
        $activoMujer    = $resultados[1];
        $totalActivos   = $activoHombre + $activoMujer;
        $cantidadesPeriodos = $this->getPeriodos($estudiantes);

        return view('grupos.mostrarEgresados', [
            'grupos'            => Grupo::where("IdGrupo", "=", $idGrupo)->get(),
            'hombre'            => $activoHombre,
            'mujer'             => $activoMujer,
            'modalidades'       => Modalidad::where('TipoModalidad', '=', 'Titulación')->get(),
            'periodos'          => Periodo::get(),
            'totalEgresados'    => $totalActivos,
            'egresadosPeriodo' => $cantidadesPeriodos
        ]);
    }


    public function contarEstudiantes($idGrupo)
    {
        $activos = Grupo_Estudiante::where("Estado", "=", "Activo")
            ->where("IdGrupo", "=", $idGrupo)->count();
        $inactivos = Grupo_Estudiante::where("Estado", "<>", "Activo")
            ->where("IdGrupo", "=", $idGrupo)->count();
        return [$activos, $inactivos];
    }
}
