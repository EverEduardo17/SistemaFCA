<?php

namespace App\Http\Controllers;

use App\Models\Baja;
use App\Http\Requests\BajaRequest;
use App\Models\Motivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BajaController extends Controller
{
    public function store(BajaRequest $request)
    {
        $input  = $request->validated();
        $existe = Baja::where("IdTrayectoria", "=", $input['IdTrayectoria'])->where("IdPeriodoBaja", "=", $input['IdPeriodoBaja'])->count();
        if ($existe > 0) {
            Session::flash('flash', [['type' => "danger", 'message' => "El estudiante ya está dado de baja en el periodo seleccionado."]]);
            return redirect()->route('estudiantesGrupo', $input['IdGrupo']);
        }

        $bajas = Baja::where("IdTrayectoria", "=", $input['IdTrayectoria'])->get();
        //TODO: Preguntar el número máximo de bajas y bajas simultáneas
        //TODO: Si existen más de una baja, cómo se va a manejar en la tabla.
        if ($bajas->count() > 5) {
            Session::flash('flash', [['type' => "danger", 'message' => "El estudiante no puede realizar más bajas."]]);
            return redirect()->route('estudiantesGrupo', $input['IdGrupo']);
        }
        foreach ($bajas as $baja) {
            if ($baja != null && $baja->TipoBaja == "Definitiva") {
                Session::flash('flash', [['type' => "danger", 'message' => "El estudiante ya está dado de baja definitiva."]]);
                return redirect()->route('estudiantesGrupo', $input['IdGrupo']);
            }
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

    private function comprobarMotivo($input)
    {
        $motivo = Motivo::where('IdMotivo', '=', $input['IdMotivo'])->get()->last();
        if ($input['TipoBaja'] == "Temporal" || $input['TipoBaja'] == "Ambos") {
            return ($motivo->TipoBaja == "Temporal");
        } else {
            return ($motivo->TipoBaja == "Definitiva");
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
