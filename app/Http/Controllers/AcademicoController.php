<?php

namespace App\Http\Controllers;

use App\Academico;
use App\DatosPersonales;
use App\Usuario;
use App\Http\Requests\AcademicoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AcademicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $academicos = Academico::with('usuario.datosPersonales')->get();
        return view(
            'academicos.index',
            ["academicos" => $academicos]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('academicos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AcademicoRequest $request)
    {
        $input = $request->validated();
        DB::beginTransaction();

        $idUsuarioDB = DB::table('usuario')->insertGetId([
            'name'      => $input['name'],
            'email' => $input['email'],
            'password' => Crypt::encryptString($input['password'])
            // 'CreatedBy'         => $this->idUsuario,
            // 'UpdatedBy'         => $this->idUsuario
        ]);

        $idAcademico = DB::table('academico')->insertGetId([
            'idAcademico'      => $idUsuarioDB,
            'NoPersonalAcademico' => $input['NoPersonalAcademico'],
            'RfcAcademico' => $input['RfcAcademico'],
            'IdUsuario' => $idUsuarioDB
            // 'CreatedBy'         => $this->idUsuario,
            // 'UpdatedBy'         => $this->idUsuario
        ]);

        $idDatosPersonales = DB::table('datospersonales')->insertGetId([
            'idDatosPersonales'      => $idUsuarioDB,
            'NombreDatosPersonales' => $input['NombreDatosPersonales'],
            'ApellidoPaternoDatosPersonales' => $input['ApellidoPaternoDatosPersonales'],
            'ApellidoMaternoDatosPersonales' => $input['ApellidoMaternoDatosPersonales'],
            'IdUsuario' => $idUsuarioDB
            // 'CreatedBy'         => $this->idUsuario,
            // 'UpdatedBy'         => $this->idUsuario
        ]);

        if ($idUsuarioDB == null || $idUsuarioDB == 0 || $idAcademico == null || $idAcademico == 0 || $idDatosPersonales == null || $idDatosPersonales == 0) {
            DB::rollBack();
            Session::flash('flash', [['type' => "danger", 'message' => "Error al registrar al Académico."]]);
            return redirect()->route('academicos.index');
        }

        DB::commit();

        Session::flash('flash', [['type' => "success", 'message' => "Académico registrado correctamente."]]);
        return redirect()->route('academicos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Academico  $academico
     * @return \Illuminate\Http\Response
     */
    public function show(Academico $academico)
    {
        return view('academicos.show', [
            "academico" => $academico
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Academico  $academico
     * @return \Illuminate\Http\Response
     */
    public function edit(Academico $academico)
    {
        return view('academicos.edit', [
            "academico" => $academico
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Academico  $academico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Academico $academico)
    {
        $request->validate([
            'NombreDatosPersonales' => 'required',
            'ApellidoPaternoDatosPersonales' => 'required',
            'ApellidoMaternoDatosPersonales' => 'required',
            'NoPersonalAcademico' => 'unique:academico,NoPersonalAcademico,'.$academico->NoPersonalAcademico.',NoPersonalAcademico',
            'RfcAcademico' => 'unique:academico,RfcAcademico,'.$academico->RfcAcademico.',RfcAcademico',
            'name' => 'unique:usuario,name,'.$academico->usuario->name.',name',
            'email' => 'unique:academico,email,'.$academico->usuario->email.',email'
        ]);
        try {
            DB::beginTransaction();

            DB::table('usuario')->where('IdUsuario', $academico->IdUsuario)->update([
                'name'       => $request->name,
                'email'  => $request->email
            ]);
            DB::table('academico')->where('IdUsuario', $academico->IdUsuario)->update([
                'NoPersonalAcademico' => $request->NoPersonalAcademico,
                'RfcAcademico'        => $request->RfcAcademico
            ]);
            DB::table('datospersonales')->where('IdUsuario', $academico->IdUsuario)->update([
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Academico  $academico
     * @return \Illuminate\Http\Response
     */
    public function destroy(Academico $academico)
    {
        //!! Checar bien, aún no funciona
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
