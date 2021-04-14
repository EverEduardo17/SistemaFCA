<?php

namespace App\Http\Controllers;

use App\Http\Requests\TitulacionRequest;
use App\Models\Practicas_Estudiante;
use App\Models\Servicio_Social_Estudiante;
use App\Models\Titulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TitulacionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TitulacionRequest $request)
    {
        $input = $request->validated();
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

            Session::flash('flash', [['type' => "danger", 'message' => "El egreso NO pudo ser creado correctamente."]]);
            return redirect()->back();
        }
    }
}
