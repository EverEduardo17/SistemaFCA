<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Http\Requests\DocumentoRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DocumentoController extends Controller
{
    public function index() {
        //
    }

    public function create() {
        //
    }

    public function store(DocumentoRequest $request) {
        Gate::authorize('havepermiso', 'constancias-crear');
        $request->validated();
        $evento = Evento::findOrFail($request->evento);


        $fileName = time().'_Documento_'.$request->FormatoDocumento->getClientOriginalName();
        $filePath = $request->file('FormatoDocumento');
        Storage::disk('documento')->put($fileName, File::get($filePath));

        try {
            DB::beginTransaction();
                if( $request->file() ) {
                    DB::table('Documento')->insert([
                        'NombreDocumento'       => $request->NombreDocumento,
                        'DescripcionDocumento'  => $request->DescripcionDocumento,
                        'FormatoDocumento'      => $fileName,
                        'IdEvento'              => $evento->IdEvento
                    ]);
                }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Session::flash('flash', [ ['type' => "danger", 'message' => "Error al registrar el documento."] ]);
            return redirect()->route('eventos.show', $evento->IdEvento);
        }
        Session::flash('flash', [ ['type' => "success", 'message' => "Documento agregado con exito."] ]);
        return redirect()->route('eventos.show', $evento->IdEvento);
    }

    public function show($id) {
        Gate::authorize('havepermiso', 'constancias-detalles');
        $documento = Documento::findOrFail( $id );
        return Storage::disk('documento')->download( $documento->FormatoDocumento );
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        Gate::authorize('havepermiso', 'constancias-editar-propio');
        $documento = Documento::findOrFail( $id );
        $evento = Evento::findOrFail( $documento->IdEvento );

        $request->validate([
            'NombreDocumento'       => 'required | String',
            'DescripcionDocumento'  => 'required | String',
        ]);

        try {
            DB::beginTransaction();
                DB::table('Documento')->where('IdDocumento', $documento->IdDocumento)->update([
                    'NombreDocumento'       => $request->NombreDocumento,
                    'DescripcionDocumento'  => $request->DescripcionDocumento,
                ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Session::flash('flash', [ ['type' => "danger", 'message' => "Error al editar el documento."] ]);
            return redirect()->route('eventos.show', $evento->IdEvento);
        }
        Session::flash('flash', [ ['type' => "success", 'message' => "Documento editado con exito."] ]);
        return redirect()->route('eventos.show', $evento->IdEvento);

    }

    public function destroy($id) {
        Gate::authorize('havepermiso', 'constancias-eliminar-propio');
        $documento = Documento::findOrFail( $id );
        $documento->delete();

        Session::flash('flash', [ ['type' => "success", 'message' => "Documento Eliminado Correctamente."] ]);
        return redirect()->back();
    }
}
