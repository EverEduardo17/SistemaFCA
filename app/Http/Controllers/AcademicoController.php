<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademicoRequest;
use App\Models\Academico;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
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

        $roles = Role::all();

        return view('academicos.create')->with('roles', $roles);
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
                    'IdRole'        => $input['IdRole'],
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
        Gate::authorize('havepermiso', 'academicos-detalles');

        $academico = Academico::with('usuario.datosPersonales')->findOrFail($idAcademico);

        return view('academicos.show', [
            "academico" => $academico,
        ]);
    }

    public function edit($idAcademico) 
    {
        Gate::authorize('havepermiso', 'academicos-detalles');

        $roles = Role::all();

        $academico = Academico::with('usuario.datosPersonales')->findOrFail($idAcademico);

        return view('academicos.edit', [
            "academico" => $academico,
            "roles" => $roles
        ]);
    }

    public function update(AcademicoRequest $request, Academico $academico) 
    {
        Gate::authorize('havepermiso', 'academicos-detalles');

        $request->validated();

        if ($request->filled('password')) {
            $academico->usuario->update([
                'password' => bcrypt($request->password)
            ]);
        }
    
        $academico->update($request->all());
        $academico->usuario->update($request->except('password'));
        $academico->usuario->datosPersonales->update($request->all());
        $academico->usuario->roles()->sync($request->IdRole);
    

        Session::flash('flash', [['type' => "success", 'message' => "Académico actualizado con éxito."]]);

        return redirect()->route('academicos.index');
    }

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
