<?php

namespace App\Http\Controllers;

use App\Models\Academico;
use App\Models\DatosPersonales;
use App\Models\Usuario;
use App\Http\Requests\AcademicoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class AcademicoController extends Controller 
{
    public function index() {
        Gate::authorize('havepermiso', 'academicos-listar');

        $academicos = Academico::with('usuario.datosPersonales')->get();

        return view(
            'academicos.index',
            ["academicos" => $academicos]
        );
    }

    public function create() {
        Gate::authorize('havepermiso', 'academicos-crear');

        return view('academicos.create');
    }

    public function store(AcademicoRequest $request) 
    {
        Gate::authorize('havepermiso', 'academicos-crear');

        $request->validated();

        $input = $request->validated();
        try{
            DB::beginTransaction();

                $idUsuarioDB = DB::table('Usuario')->insertGetId([
                    'name'              => $input['name'],
                    'email'             => $input['email'],
                    'password'          => bcrypt($input['password']),
                    'CreatedBy'         => Auth::user()->IdUsuario,
                    'UpdatedBy'         => Auth::user()->IdUsuario
                ]);

                DB::table('Academico')->insert([
                    'idAcademico'           => $idUsuarioDB,
                    'NoPersonalAcademico'   => $input['NoPersonalAcademico'],
                    'RfcAcademico'          => $input['RfcAcademico'],
                    'IdUsuario'             => $idUsuarioDB,
                    'CreatedBy'             => Auth::user()->IdUsuario,
                    'UpdatedBy'             => Auth::user()->IdUsuario
                ]);

                DB::table('DatosPersonales')->insert([
                    'idDatosPersonales'                 => $idUsuarioDB,
                    'NombreDatosPersonales'             => $input['NombreDatosPersonales'],
                    'ApellidoPaternoDatosPersonales'    => $input['ApellidoPaternoDatosPersonales'],
                    'ApellidoMaternoDatosPersonales'    => $input['ApellidoMaternoDatosPersonales'],
                    'IdUsuario'                         => $idUsuarioDB,
                    'CreatedBy'                         => Auth::user()->IdUsuario,
                    'UpdatedBy'                         => Auth::user()->IdUsuario
                ]);

                DB::table('Role_Usuario')->insert([
                    'IdUsuario'     => $idUsuarioDB,
                    'IdRole'        => 2,
                    'CreatedBy'     => Auth::user()->IdUsuario,
                    'UpdatedBy'     => Auth::user()->IdUsuario
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

    public function show($idAcademico) 
    {
        Gate::authorize('havepermiso', 'academicos-listar');

        $academico = Academico::with('usuario.datosPersonales')->findOrFail($idAcademico);

        return view('academicos.show', [
            "academico" => $academico
        ]);
    }

    public function edit($idAcademico) 
    {
        Gate::authorize('havepermiso', 'academicos-editar');

        $academico = Academico::with('usuario.datosPersonales')->findOrFail($idAcademico);

        return view('academicos.edit', [
            "academico" => $academico
        ]);
    }

    public function update(AcademicoRequest $request, Academico $academico) 
    {
        Gate::authorize('havepermiso', 'academicos-editar');

        $request->validated();

        if ($request->filled('password')) {
            $academico->usuario->update([
                'password' => bcrypt($request->password)
            ]);
        }
    
        $academico->update($request->all());
        $academico->usuario->update($request->except('password'));
        $academico->usuario->datosPersonales->update($request->all());
    

        Session::flash('flash', [['type' => "success", 'message' => "Académico actualizado con éxito."]]);

        return redirect()->route('academicos.index');
    }

    // public function update(Request $request, $idAcademico) {
    //     Gate::authorize('havepermiso', 'academicos-editar');

    //     $academico = Academico::with('usuario.datosPersonales')->findOrFail($idAcademico);

    //     $request->validate([
    //         'NombreDatosPersonales' => 'required',
    //         'ApellidoPaternoDatosPersonales' => 'required',
    //         'ApellidoMaternoDatosPersonales' => 'required',
    //         'NoPersonalAcademico' => 'unique:Academico,NoPersonalAcademico,'.$academico->IdAcademico.',IdAcademico',
    //         'RfcAcademico' => 'unique:Academico,RfcAcademico,'.$academico->IdAcademico.',IdAcademico',
    //         'name' => 'unique:Usuario,name,'.$academico->usuario->IdUsuario.',IdUsuario',
    //         'email' => 'unique:Usuario,email,'.$academico->usuario->IdUsuario.',IdUsuario'
    //     ]);

    //     try {
    //         DB::beginTransaction();
    //             DB::table('Usuario')->where('IdUsuario', $academico->IdUsuario)->update([
    //                 'name'       => $request->name,
    //                 'email'  => $request->email
    //             ]);
    //             DB::table('Academico')->where('IdUsuario', $academico->IdUsuario)->update([
    //                 'NoPersonalAcademico' => $request->NoPersonalAcademico,
    //                 'RfcAcademico'        => $request->RfcAcademico
    //             ]);
    //             DB::table('DatosPersonales')->where('IdUsuario', $academico->IdUsuario)->update([
    //                 'NombreDatosPersonales'             => $request->NombreDatosPersonales,
    //                 'ApellidoPaternoDatosPersonales'    => $request->ApellidoPaternoDatosPersonales,
    //                 'ApellidoMaternoDatosPersonales'    => $request->ApellidoMaternoDatosPersonales,
    //             ]);
    //         DB::commit();
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         Session::flash('flash', [['type' => "danger", 'message' => "Error al editar al Académico."]]);
    //         return redirect()->route('academicos.index');
    //     }
    //     Session::flash('flash', [['type' => "success", 'message' => "Académico actualizado con éxito."]]);
    //     return redirect()->route('academicos.index');
    // }

    public function destroy($idAcademico) 
    {
        Gate::authorize('havepermiso', 'academicos-eliminar');

        $academico = Academico::with('usuario.datosPersonales')->findOrFail($idAcademico);


        if ($academico->usuario->IdUsuario === Auth::user()->IdUsuario) {
            Session::flash('flash', [ ['type' => "danger", 'message' => "No puedes eliminar tu propio usuario."] ]);
            return redirect()->route('academicos.index');
        } else if ($academico->usuario->IdUsuario === 1001) {
            Session::flash('flash', [ ['type' => "danger", 'message' => "No se puede eliminar a este usuario."] ]);
            return redirect()->route('academicos.index');
        }

        try {
            $academico->delete();
            $academico->usuario->delete();

            Session::flash('flash', [ ['type' => "success", 'message' => "Académico eliminado correctamente."] ]);
            return redirect()->route('academicos.index');
        } catch (\Throwable $throwable){
            Session::flash('flash', [ ['type' => "danger", 'message' => "El Académico No pudo ser eliminado correctamente."] ]);
            return redirect()->route('academicos.index');
        }
    }
}
