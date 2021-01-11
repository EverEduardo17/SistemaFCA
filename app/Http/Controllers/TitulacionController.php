<?php

namespace App\Http\Controllers;

use App\Titulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TitulacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $input = $request->validate([
            'PromedioEgreso'        => 'required',
            'FechaInicioTramite'    => 'required | date',
            'FechaFinTramite'       => 'required | date',
            'EstadoTitulacion'      => 'required',
            'MencionHonorifica'     => 'required',
            'ResultadoTitulacion'   => '',
            'IdModalidad'           => 'required',
            'IdGrupo'               => 'required',
            'IdTrayectoria'         => 'required',
            'IdPeriodoTitulacion'   => 'required'
            
        ]);
        try {
            Titulacion::create($input);
            DB::beginTransaction();
            DB::table('Grupo_Estudiante')->where('IdTrayectoria', $input['IdTrayectoria'])->update([
                'Estado' => "Egresado"
            ]);
            DB::commit();
            Session::flash('flash', [['type' => "success", 'message' => "Egreso agregado correctamente."]]);
            return redirect()->route('estudiantesGrupo', $input['IdGrupo']);
        } catch (\Throwable $throwable) {
            dd($throwable);
            Session::flash('flash', [['type' => "danger", 'message' => "El egreso NO pudo ser creado correctamente."]]);
            return redirect()->route('estudiantesGrupo', $input['IdGrupo']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
