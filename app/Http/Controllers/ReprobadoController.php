<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReprobadoRequest;
use App\Models\Reprobado;
use App\Models\Reprobados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReprobadoController extends Controller
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
    public function store(ReprobadoRequest $request)
    {
        $input = $request->validated();
        $reprobadoPeriodo = Reprobado::where("IdTrayectoria", "=", $input['IdTrayectoria'])->where("IdPeriodo", "=", $input['IdPeriodo'])->count();
        if ($reprobadoPeriodo > 0) {
            Session::flash('flash', [['type' => "danger", 'message' => "El estudiante ya cuenta con alguna materia reprobada registrada en el periodo seleccionado."]]);
            return redirect()->back();
        }
        try {
            Reprobado::create($request->validated());
            DB::beginTransaction();
            DB::table('Trayectoria')->where('IdTrayectoria', $input['IdTrayectoria'])->update([
                'EstudianteRegular' => "0"
            ]);
            DB::commit();
            Session::flash('flash', [['type' => "success", 'message' => "Materia reprobada agregada correctamente."]]);
            return redirect()->back();
        } catch (\Throwable $throwable) {
            dd($throwable);
            Session::flash('flash', [['type' => "danger", 'message' => "La materia reprobada NO pudo ser creado."]]);
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
