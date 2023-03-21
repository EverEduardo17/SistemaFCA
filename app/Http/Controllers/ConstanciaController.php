<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConstanciaRequest;
use App\Models\Constancia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ConstanciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $constancias = Constancia::with('usuario.datosPersonales')->get();
        return view('constancias.index', compact('constancias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('constancias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConstanciaRequest $request)
    {
        $input = $request->validated();
        $timestamp = Carbon::now()->toDateTimeString();

        $vigenteHasta = null;
        if ($input['VigenteHasta'] !== null) {
            $vigenteHasta = formatearDate($input['VigenteHasta']);
        }

        // TODO - agregar dueño de la plantilla
        try {
            DB::beginTransaction();
            
            $datos = [
                'NombreConstancia' => $input['NombreConstancia'],
                'DescripcionConstancia' => $input['DescripcionConstancia'],
                'VigenteHasta' => $vigenteHasta,
                'CreatedBy' => Auth::user()->IdUsuario,
                'CreatedAt' => $timestamp,
                'UpdatedAt' => $timestamp,
            ];

            $idConstanciaDB = DB::table('Constancia')->insertGetId($datos);

            DB::commit();

            $plantilla = $request->file('Plantilla');
            $plantilla->storeAs('constancias/' , 'c_'.$idConstanciaDB.'.docx');
        }
        catch (\Throwable $throwable){
            DB::rollBack();
            Session::flash('flash', [['type' => "danger", 'message' => $throwable->getMessage()]]);
            return redirect()->route('constancias.index');
        }

        Session::flash('flash', [['type' => "success", 'message' => "Constancia registrada correctamente."]]);
        return redirect()->route('constancias.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Constancia  $constancia
     */
    public function show(Constancia $constancia)
    {
        $estudiantes = $constancia->estudiantes;
        
        return view('constancias.show', compact('constancia', 'estudiantes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Constancia  $constancia
     */
    public function edit(Constancia $constancia)
    {
        return view('constancias.edit', compact('constancia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Constancia  $constancia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Constancia $constancia)
    {
        $input = $request->validate([
            'NombreConstancia'        => 'required | string',
            'DescripcionConstancia'   => 'required | string',
            'VigenteHasta'            => 'nullable | date_format:d/m/Y',
            'Plantilla'               => 'nullable | file | mimes:doc,docx',
        ]);

        if ($request->hasFile('Plantilla')) {
                $request->file('Plantilla')->storeAs('constancias' , 'c_'.$constancia->IdConstancia.'.docx');
            }

        $timestamp = Carbon::now()->toDateTimeString();

        $vigenteHasta = null;
        if ($input['VigenteHasta'] !== null) {
            $vigenteHasta = formatearDate($input['VigenteHasta']);
        }
        try {
            DB::beginTransaction();
            
            $datos = [
                'NombreConstancia' => $input['NombreConstancia'],
                'DescripcionConstancia' => $input['DescripcionConstancia'],
                'VigenteHasta' => $vigenteHasta,
                'UpdatedAt' => $timestamp,
            ];
            
            // si la fecha no es nula, enviala a la BD
            if ($vigenteHasta !== null) {
                $datos['VigenteHasta'] = $vigenteHasta;
            }
            else {
                $datos['VigenteHasta'] = null;
            }

            DB::table('Constancia')->where('IdConstancia',$constancia->IdConstancia)->update($datos);

            DB::commit();
        }
        catch (\Throwable $throwable){
            DB::rollBack();
            Session::flash('flash', [['type' => "danger", 'message' => $throwable->getMessage()]]);
            return redirect()->route('constancias.index');
        }
        Session::flash('flash', [['type' => "success", 'message' => "Constancia actualizada con éxito."]]);
        return redirect()->route('constancias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Constancia  $constancia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Constancia $constancia)
    {
        //
    }

    public function downloadConstancia($id, $nombreConstancia)
    {
        $constancia = Constancia::findOrFail($id);
        $pathToFile = storage_path('app/constancias/c_' . $id . '.docx');
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        return response()->download($pathToFile, $nombreConstancia . '.docx', $headers);
    }

    public function downloadConstanciaGenerica()
    {
        $pathToFile = public_path('constancias plantilla/Plantilla.docx');
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        return response()->download($pathToFile, 'Plantilla.docx', $headers);
    }

}
