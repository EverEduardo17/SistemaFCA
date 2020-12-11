<?php

namespace App\Http\Controllers;

use App\Cohorte;
use App\Grupo;
use App\Modalidad;
use App\Periodo;
use App\ProgramaEducativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CohorteController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param string $NombreCohorte
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nombreCohorte = 'S200')
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
