<?php

namespace App\Http\Controllers;

use App\Baja;
use App\Http\Requests\BajaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BajaController extends Controller
{
    private function comprobarMotivo($input)
    {
        $motivo = $input['IdMotivo'];
        if ($input['TipoBaja'] == "Temporal") {
            return ($motivo == 1 || $motivo == 2 || $motivo == 4 || $motivo == 5 || $motivo == 6);
        } else {
            return ($motivo == 3 || $motivo == 7 || $motivo == 8 || $motivo == 9);
        }
    }

    public function store(BajaRequest $request)
    {
        $input  = $request->validated();
        $existe = Baja::where("IdTrayectoria", "=", $input['IdTrayectoria'])->where("IdPeriodoBaja", "=", $input['IdPeriodoBaja'])->count();
        if ($existe > 0) {
            Session::flash('flash', [['type' => "danger", 'message' => "El estudiante ya está dado de baja en el periodo seleccionado."]]);
            return redirect()->route('estudiantesGrupo', $input['IdGrupo']);
        }
        if (!$this->comprobarMotivo($input)) {
            Session::flash('flash', [['type' => "danger", 'message' => "El motivo seleccionado no es aplicable para el tipo de baja seleccionado."]]);
            return redirect()->back();
        }
        try {
            Baja::create($request->validated());
            DB::beginTransaction();
            DB::table('Grupo_Estudiante')->where('IdTrayectoria', $input['IdTrayectoria'])->update([
                'Estado' => "Baja"
            ]);
            DB::commit();
            Session::flash('flash', [['type' => "success", 'message' => "Baja registrada correctamente."]]);
            return redirect()->route('estudiantesGrupo', $input['IdGrupo']);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            Session::flash('flash', [['type' => "danger", 'message' => "La Baja NO pudo ser registrada correctamente."]]);
            return redirect()->back();
        }
    }



    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }
}
