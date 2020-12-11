<?php

namespace App\Http\Controllers;

use App\Cohorte;
use App\Grupo;
use App\Grupo_Estudiante;
use App\Http\Requests\GrupoRequest;
use App\Periodo;
use App\ProgramaEducativo;
use App\Trayectoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $idFCA = DB::table('facultad')
        //     ->where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('idFacultad');
        return view('grupos.index', [
            // 'grupos' => DB::table('grupo')
            //     ->where('IdFacultad', '=', $idFCA)
            //     ->get(),            
            'grupos' => Grupo::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $idFCA = DB::table('facultad')
            ->where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('idFacultad');
        return view('grupos.create', [
            'grupos' => new Grupo(),
            'periodos' => Periodo::get(),
            'cohortes' => DB::table('cohorte')
                ->orderBy('IdCohorte', 'desc')
                ->get(),
            'programas' => DB::table('programa_educativo')
                ->where('IdFacultad', '=', $idFCA)
                ->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GrupoRequest $request)
    {
        $ocupado = DB::table('grupo')->where([
            ['NombreGrupo', '=', $request->NombreGrupo],
            ['IdProgramaEducativo', '=', $request->IdProgramaEducativo],
            ['IdCohorte', '=', $request->IdCohorte]
        ])->count();
        if ($ocupado > 0) {
            Session::flash('flash', [['type' => "danger", 'message' => "El grupo " . $request->NombreGrupo . " ya fue registrado en ese cohorte."]]);
            return redirect()->route('grupos.index');
        } else {
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Grupo $grupo)
    {
        return view('grupos.show', [
            'grupos' => $grupo
        ]);
    }

    private function getCantidades($estudiantes)
    {
        $hombre = 0;
        $mujer = 0;

        foreach ($estudiantes as $estudiante) {
            $idDatosPersonales = DB::table('trayectoria')
                ->where('IdTrayectoria', '=', $estudiante->IdTrayectoria)
                ->value('IdDatosPersonales');
            $genero = DB::table('datospersonales')
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


    public function mostrarGrupo($nombreCohorte, int $idGrupo)
    {
        $estudiantes = DB::table('grupo_estudiante')
            ->where('estado', '=', 'Activo')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();
        $resultados = $this->getCantidades($estudiantes);
        $activoHombre = $resultados[0];
        $activoMujer = $resultados[1];
        $totalActivos  = $activoHombre + $activoMujer;

        $estudiantes = DB::table('grupo_estudiante')
            ->where('estado', '=', 'Egresado')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();

        $resultados = $this->getCantidades($estudiantes);
        $egresadoHombre = $resultados[0];
        $egresadoMujer = $resultados[1];
        $totalEgresados  = $egresadoHombre + $egresadoMujer;

        $estudiantes = DB::table('grupo_estudiante')
            ->where('estado', '=', 'Entrante')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();

        $resultados = $this->getCantidades($estudiantes);
        $entranteHombre = $resultados[0];
        $entranteMujer = $resultados[1];
        $totalEntrantes = $entranteHombre + $entranteMujer;

        $estudiantes = DB::table('grupo_estudiante')
            ->where('estado', '=', 'Saliente')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();

        $resultados = $this->getCantidades($estudiantes);
        $salienteHombre = $resultados[0];
        $salienteMujer = $resultados[1];
        $totalSalientes  = $salienteHombre + $salienteMujer;

        $estudiantes = DB::table('grupo_estudiante')
            ->where('estado', '=', 'Baja')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();

        $resultados = $this->getCantidades($estudiantes);
        $bajaHombre = $resultados[0];
        $bajaMujer = $resultados[1];
        $totalBajas  = $bajaHombre + $bajaMujer;

        return view('grupos.mostrarGrupo', [
            'grupos' => Grupo::where("IdGrupo", "=", $idGrupo)->get(),
            'activoHombre' => $activoHombre,
            'activoMujer' => $activoMujer,
            'totalActivos' => $totalActivos,
        
            'egresadoHombre' => $egresadoHombre,
            'egresadoMujer' => $egresadoMujer,
            'totalEgresados' => $totalEgresados,

            'entranteHombre' => $entranteHombre,
            'entranteMujer' => $entranteMujer,
            'totalEntrantes' => $totalEntrantes,

            'salienteHombre' => $salienteHombre,
            'salienteMujer' => $salienteMujer,
            'totalSalientes' => $totalSalientes,

            'bajaHombre' => $bajaHombre,
            'bajaMujer' => $bajaMujer,
            'totalBajas' => $totalBajas,
        ]);
    }

    public function mostrarEstado($nombreCohorte, int $idGrupo)
    {
        $estudiantes = DB::table('grupo_estudiante')
            ->where('estado', '=', 'Activo')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();
        $resultados = $this->getCantidades($estudiantes);
        $activoHombre = $resultados[0];
        $activoMujer = $resultados[1];
        $totalActivos  = $activoHombre + $activoMujer;

        $estudiantes = DB::table('grupo_estudiante')
            ->where('estado', '=', 'Egresado')
            ->where('IdGrupo', '=', $idGrupo)
            ->get();

        $resultados = $this->getCantidades($estudiantes);
        $egresadoHombre = $resultados[0];
        $egresadoMujer = $resultados[1];
        $totalEgresados  = $egresadoHombre + $egresadoMujer;

        $estudiantes = DB::table('grupo_estudiante')
            ->where('estado', '=', 'Baja')
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




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Grupo $grupo)
    {
        $idFCA = DB::table('facultad')
            ->where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('idFacultad');
        return view('grupos.edit', [
            'grupos' => $grupo,
            'periodos' => Periodo::get(),
            'cohortes' => DB::table('cohorte')
                ->orderBy('IdCohorte', 'desc')
                ->get(),
            'programas' => DB::table('programa_educativo')
                ->where('IdFacultad', '=', $idFCA)
                ->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GrupoRequest $request, Grupo $grupo)
    {
        $ocupado = DB::table('grupo')->where([
            ['NombreGrupo', '=', $request->NombreGrupo],
            ['IdProgramaEducativo', '=', $request->IdProgramaEducativo],
            ['IdCohorte', '=', $request->IdCohorte]
        ])->count();
        if ($ocupado > 0) {
            Session::flash('flash', [['type' => "danger", 'message' => "El grupo " . $request->NombreGrupo . " ya fue registrado en ese cohorte."]]);
            return redirect()->route('grupos.index');
        } else {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
}
