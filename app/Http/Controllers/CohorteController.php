<?php

namespace App\Http\Controllers;

use App\Models\Cohorte;
use App\Models\Grupo;
use App\Models\Modalidad;
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
        $idCohorte = DB::table('cohorte')
            ->where('NombreCohorte', $nombreCohorte)->value('IdCohorte');
        $idFCA = DB::table('facultad')
            ->where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('idFacultad');
        return view('cohorte.show', [
            'cohortes' => DB::table('cohorte')
                ->orderBy('IdCohorte', 'desc')
                ->get(),
            'programas' => DB::table('programa_educativo')
                ->where('IdFacultad', '=', $idFCA)
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
        // dd($nombreCohorte->NombreCohorte);
        $idCohorte = DB::table('Cohorte')
            ->where('NombreCohorte', $nombreCohorte->NombreCohorte)->value('IdCohorte');
        $idFCA = DB::table('facultad')
            ->where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('idFacultad');
        return view('cohorte.show', [
            'cohortes' => DB::table('cohorte')
                ->orderBy('IdCohorte', 'desc')
                ->get(),
            'programas' => DB::table('programa_educativo')
                ->where('IdFacultad', '=', $idFCA)
                ->get(),
            'grupos' => Grupo::where('IdCohorte', '=', $idCohorte)->get(),
            'periodos' => Periodo::get(),
            'idCohorte' => $idCohorte,
            'nombreCohorte' => $nombreCohorte->NombreCohorte,
            'modalidades' => Modalidad::get(),
        ]);
    }
}
