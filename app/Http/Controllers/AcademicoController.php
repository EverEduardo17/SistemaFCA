<?php

namespace App\Http\Controllers;

use App\Academico;
use App\DatosPersonales;
use App\Usuario;
use App\Http\Requests\AcademicoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class AcademicoController extends Controller
{
    public function index()
    {
        Gate::authorize('havepermiso', 'tipoorganizador-listar');
        $academicos = Academico::with('usuario.datosPersonales')->get();
        return view(
            'academicos.index',
            ["academicos" => $academicos]
        );
    }

    public function create()
    {
        Gate::authorize('havepermiso', 'tipoorganizador-crear');
        return view('academicos.create');
    }

    public function store(AcademicoRequest $request)
    {
        Gate::authorize('havepermiso', 'tipoorganizador-crear');
        $input = $request->validated();
        try{
            DB::beginTransaction();

                $idUsuarioDB = DB::table('Usuario')->insertGetId([
                    'name'              => $input['name'],
                    'email'             => $input['email'],
                    'password'          => Crypt::encryptString($input['password'])
                    // 'CreatedBy'         => $this->idUsuario,
                    // 'UpdatedBy'         => $this->idUsuario
                ]);

                $idAcademico = DB::table('Academico')->insertGetId([
                    'idAcademico'           => $idUsuarioDB,
                    'NoPersonalAcademico'   => $input['NoPersonalAcademico'],
                    'RfcAcademico'          => $input['RfcAcademico'],
                    'IdUsuario'             => $idUsuarioDB
                    // 'CreatedBy'         => $this->idUsuario,
                    // 'UpdatedBy'         => $this->idUsuario
                ]);

                $idDatosPersonales = DB::table('DatosPersonales')->insertGetId([
                    'idDatosPersonales'                 => $idUsuarioDB,
                    'NombreDatosPersonales'             => $input['NombreDatosPersonales'],
                    'ApellidoPaternoDatosPersonales'    => $input['ApellidoPaternoDatosPersonales'],
                    'ApellidoMaternoDatosPersonales'    => $input['ApellidoMaternoDatosPersonales'],
                    'IdUsuario'                         => $idUsuarioDB
                    // 'CreatedBy'                      => $this->idUsuario,
                    // 'UpdatedBy'                      => $this->idUsuario
                ]);

            DB::commit();
        }catch (\Throwable $throwable){
            DB::rollBack();
            Session::flash('flash', [['type' => "danger", 'message' => "Error al registrar al Académico."]]);
            return redirect()->route('academicos.index');
        }

        Session::flash('flash', [['type' => "success", 'message' => "Académico registrado correctamente."]]);
        return redirect()->route('academicos.index');
    }

    public function show(Academico $academico)
    {
        Gate::authorize('havepermiso', 'tipoorganizador-leer');
        return view('academicos.show', [
            "academico" => $academico
        ]);
    }

    public function edit(Academico $academico)
    {
        Gate::authorize('havepermiso', 'tipoorganizador-editar');
        return view('academicos.edit', [
            "academico" => $academico
        ]);
    }

    public function update(Request $request, Academico $academico)
    {
        Gate::authorize('havepermiso', 'tipoorganizador-editar');
        $request->validate([
            'NombreDatosPersonales' => 'required',
            'ApellidoPaternoDatosPersonales' => 'required',
            'ApellidoMaternoDatosPersonales' => 'required',
            'NoPersonalAcademico' => 'unique:Academico,NoPersonalAcademico,'.$academico->IdAcademico.',IdAcademico',
            'RfcAcademico' => 'unique:Academico,RfcAcademico,'.$academico->IdAcademico.',IdAcademico',
            'name' => 'unique:Usuario,name,'.$academico->usuario->IdUsuario.',IdUsuario',
            'email' => 'unique:Usuario,email,'.$academico->usuario->IdUsuario.',IdUsuario'
        ]);
        try {
            DB::beginTransaction();
                DB::table('Usuario')->where('IdUsuario', $academico->IdUsuario)->update([
                    'name'       => $request->name,
                    'email'  => $request->email
                ]);
                DB::table('Academico')->where('IdUsuario', $academico->IdUsuario)->update([
                    'NoPersonalAcademico' => $request->NoPersonalAcademico,
                    'RfcAcademico'        => $request->RfcAcademico
                ]);
                DB::table('DatosPersonales')->where('IdUsuario', $academico->IdUsuario)->update([
                    'NombreDatosPersonales'             => $request->NombreDatosPersonales,
                    'ApellidoPaternoDatosPersonales'    => $request->ApellidoPaternoDatosPersonales,
                    'ApellidoMaternoDatosPersonales'    => $request->ApellidoMaternoDatosPersonales,
                ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Session::flash('flash', [['type' => "danger", 'message' => "Error al editar al Académico."]]);
            return redirect()->route('academicos.index');
        }
        Session::flash('flash', [['type' => "success", 'message' => "Académico actualizado con éxito."]]);
        return redirect()->route('academicos.index');
    }

    public function destroy(Academico $academico)
    {
        Gate::authorize('havepermiso', 'tipoorganizador-eliminar');
        //!! Checar bien, aún no funciona actualizado: creo que ya funciona :D
        try {
            $academico->delete();
            Session::flash('flash', [ ['type' => "success", 'message' => "Académico eliminado correctamente."] ]);
            return redirect()->route('academicos.index');
        }catch (\Throwable $throwable){
            Session::flash('flash', [ ['type' => "danger", 'message' => "El Académico No pudo ser eliminado correctamente."] ]);
            return redirect()->route('academicos.index');
        }
    }
}
