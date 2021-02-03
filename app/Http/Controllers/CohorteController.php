<?php

namespace App\Http\Controllers;

use App\Models\Cohorte;
use App\Models\Facultad;
use App\Models\Grupo;
use App\Models\Modalidad;
use App\Models\Motivo;
use App\Models\Periodo;
use App\Models\ProgramaEducativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $idCohorte = Cohorte::where('NombreCohorte', $nombreCohorte)->value('IdCohorte');
        $idFCA = Facultad::where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('idFacultad');
        return view('cohorte.show', [
            'cohortes' => DB::table('Cohorte')
                ->orderBy('IdCohorte', 'desc')
                ->get(),
            'programas' => ProgramaEducativo::where('IdFacultad', '=', $idFCA)
                ->get(),
            'grupos' => Grupo::where('IdCohorte', '=', $idCohorte)->get(),
            'periodos' => Periodo::get(),
            'idCohorte' => $idCohorte,
            'nombreCohorte' => $nombreCohorte,
            'modalidades' => Modalidad::get(),
        ]);
    }


    public function mostrarCohorte()
    {
        $nombreCohorte = Cohorte::orderBy('IdCohorte', 'desc')->get()->first();
        $idCohorte = Cohorte::where('NombreCohorte', $nombreCohorte->NombreCohorte)->value('IdCohorte');
        $idFCA = Facultad::where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('idFacultad');
        return view('cohorte.show', [
            'cohortes' => DB::table('Cohorte')
                ->orderBy('IdCohorte', 'desc')
                ->get(),
            'programas' => ProgramaEducativo::where('IdFacultad', '=', $idFCA)
                ->get(),
            'grupos' => Grupo::where('IdCohorte', '=', $idCohorte)->get(),
            'periodos' => Periodo::get(),
            'idCohorte' => $idCohorte,
            'nombreCohorte' => $nombreCohorte->NombreCohorte,
            'modalidades' => Modalidad::get(),
        ]);
    }

    public function agregarEstudiante($nombreCohorte)
    {
        $cohorte = Cohorte::where('NombreCohorte', '=', $nombreCohorte)->get()->last();
        $idFCA = Facultad::where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('IdFacultad');
        return view('estudiantes.crearCohorte', [
            'cohorte'           => $cohorte,
            'grupos'            => Grupo::where("IdFacultad", "=", $idFCA)->where('IdCohorte','=',$cohorte->IdCohorte)->get(),
            'modalidades'       => Modalidad::where("TipoModalidad", "=", "Entrada")->get(),
            'motivos'           => Motivo::get(),
            'periodos'          => Periodo::get(),
            'programas'         => ProgramaEducativo::where('IdFacultad', $idFCA)->get(),
        ]);
    }
}
