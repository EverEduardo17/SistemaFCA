<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportarRequest;
use App\Imports\EstudiantesImport;
use App\Models\Cohorte;
use App\Models\Grupo;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportarController extends Controller
{
    public function store(ImportarRequest $request)
    {
        try {

            $input              = $request->validated();
            $nombreOriginal     = $request->Documento->getClientOriginalName();
            $nombreArchivo      =  'Archivo_' . Carbon::now()->format('j_m_Y_h_i');
            $direccionArchivo   = $request->file('Documento');
            $nombreCohorte      = strtoupper($input['NombreCohorte']);
            $nombreGrupo        = strtoupper($input['NombreGrupo']);
            Storage::disk('documento')->put($nombreArchivo, File::get($direccionArchivo));
            $array              = Excel::toArray(new EstudiantesImport, $direccionArchivo);

            if ($array[0][0][0] != 'Matrícula' || $array[0][0][1] != 'A. Paterno' || $array[0][0][2] != 'A. Materno') {
                Storage::disk('documento')->delete($nombreArchivo);
                Session::flash('flash', [['type' => "danger", 'message' => "El archivo seleccionado no es válido."]]);
                return redirect()->route('cohortes.mostrarCohorte');
            }
            return view('cohorte.mostrarDatosArchivo', [
                'nombreOriginal' => $nombreOriginal,
                'nombreArchivo' => $nombreArchivo,
                'nombreCohorte' => $nombreCohorte,
                'nombreGrupo'   => $nombreGrupo,
                'arreglos'      => $array[0],
                'datos'         => [
                    'nombreArchivo' => $nombreArchivo,
                    'nombreOriginal' => $nombreOriginal,
                    'nombreCohorte' => $nombreOriginal,
                    'nombreGrupo'   => $nombreGrupo,
                    'arreglos'      => $array[0]
                ],
            ]);
        } catch (\Throwable $exception) {
            Session::flash('flash', [['type' => "danger", 'message' => "Ocurrió un error con el archivo."]]);
            return redirect()->route('cohortes.mostrarCohorte');
        }
    }

    public function save($array)
    {
        try {
            $cohorte = Cohorte::where('NombreCohorte', '=', $datos['nombreCohorte'])->get()->last();
            if ($cohorte == null) {
                Session::flash('flash', [['type' => "danger", 'message' => "El cohorte ingresado no es válido."]]);
                return redirect()->route('cohortes.mostrarCohorte');
            }
            $grupo = Grupo::where('NombreGrupo', '=', $datos['nombreGrupo'])->where('IdCohorte', '=', $cohorte->IdCohorte)->get()->last();
            if ($grupo == null) {
                Session::flash('flash', [['type' => "danger", 'message' => "El grupo ingresado no es válido."]]);
                return redirect()->route('cohortes.mostrarCohorte');
            }


            // return view('cohorte.mostrarDatosArchivo', [
            //     'nombreOriginal' => $nombreOriginal,
            //     'nombreArchivo' => $nombreArchivo,
            //     'nombreCohorte' => $nombreCohorte,
            //     'nombreGrupo'   => $nombreGrupo,
            //     'arreglos'       => $array[0],
            // ]);
        } catch (\Throwable $exception) {
            Session::flash('flash', [['type' => "danger", 'message' => "Ocurrió un error con el archivo."]]);
            return redirect()->route('cohortes.mostrarCohorte');
        }
    }

    public function cancel($nombreArchivo)
    {
        Storage::disk('documento')->delete($nombreArchivo);
        return redirect()->route('cohortes.mostrarCohorte');
    }
}
