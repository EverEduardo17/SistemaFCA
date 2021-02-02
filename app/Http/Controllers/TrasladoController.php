<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrasladoRequest;
use App\Models\Traslado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TrasladoController extends Controller
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
    public function store(TrasladoRequest $request)
    {
        $input = $request->validated();
        $trasladoPeriodo = Traslado::where("IdTrayectoria", "=", $input['IdTrayectoria'])->where("IdPeriodo", "=", $input['IdPeriodo'])->count();
        if ($trasladoPeriodo > 0) {
            Session::flash('flash', [['type' => "danger", 'message' => "El estudiante ya cuenta con un traslado en el periodo seleccionado."]]);
            return redirect()->back();
        }
        try {
            Traslado::create($request->validated());
            DB::beginTransaction();
            DB::table('Grupo_Estudiante')->where('IdTrayectoria', $input['IdTrayectoria'])->update([
                'Estado' => "Activo",
                'TipoTraslado' => "Saliente"
            ]);
            DB::commit();
            Session::flash('flash', [['type' => "success", 'message' => "Traslado agregado correctamente."]]);
            return redirect()->back();
        } catch (\Throwable $throwable) {
            dd($throwable);
            Session::flash('flash', [['type' => "danger", 'message' => "El Traslado NO pudo ser creado."]]);
            return redirect()->back();
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
