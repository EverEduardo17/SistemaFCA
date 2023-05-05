<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConstanciaRequest;
use App\Models\Cohorte;
use App\Models\Constancia;
use App\Models\Estudiante;
use App\Models\Grupo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

            $filename = 'c_' . str_pad($idConstanciaDB, 5, '0', STR_PAD_LEFT) . '.docx';

            $plantilla = $request->file('Plantilla');
            $plantilla->storeAs('constancias/' , $filename);
        }
        catch (\Throwable $throwable){
            DB::rollBack();
            // Session::flash('flash', [['type' => "danger", 'message' => $throwable->getMessage()]]);
            Session::flash('flash', [['type' => "danger", 'message' => "Error al registrar la constancia."]]);
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
                $filename = 'c_' . str_pad($constancia->IdConstancia, 5, '0', STR_PAD_LEFT) . '.docx';

                $request->file('Plantilla')->storeAs('constancias' , $filename);
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
        try {
            $constancia->delete();
            Session::flash('flash', [['type' => "success", 'message' => "La constancia fue eliminada correctamente."]]);
            return redirect()->route('constancias.index');
        } catch (\Throwable $throwable) {
            Session::flash('flash', [['type' => "danger", 'message' => "La constancia NO pudo ser eliminada."]]);
            return redirect()->route('constancias.index');
        }
    }

    public function downloadConstancia($id, $nombreConstancia)
    {
        $filename = 'c_' . str_pad($id, 5, '0', STR_PAD_LEFT) . '.docx';

        $pathToFile = storage_path('app/constancias/' . $filename);
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        return response()->download($pathToFile, ($nombreConstancia . '.docx'), $headers);
    }

    public function downloadConstanciaGenerica()
    {
        $pathToFile = public_path('constancias plantilla/Plantilla.docx');
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        return response()->download($pathToFile, 'Plantilla.docx', $headers);
    }

    public function showEstudiante(Constancia $constancia, Estudiante $estudiante) {
        return view('constancias.estudiantes.showEstudiante', compact('constancia', 'estudiante'));
    }

    public function indexGrupos(Constancia $constancia) {
        $grupos = Grupo::all();
        return view('constancias.estudiantes.indexGrupos', compact('constancia', 'grupos'));
    }
    
    public function indexEstudiantes(Constancia $constancia, Grupo $grupo) {
        $cohorte = Cohorte::where('IdCohorte', $grupo->IdCohorte)->get()->last();
        $estudiantes = $grupo->trayectorias;
        return view('constancias.estudiantes.indexEstudiantes', compact('constancia', 'grupo', 'cohorte', 'estudiantes'));
    }

    public function addEstudianteConstancia(Request $request)
    {
        $idEstudiante = $request->input('idEstudiante');
        $idConstancia = $request->input('idConstancia');
        $estudiante = Estudiante::findOrFail($idEstudiante);
        $constancia = Constancia::findOrFail($idConstancia);
        if ($estudiante->constancias()->where('Constancia.IdConstancia', $constancia->IdConstancia)->exists()) {
            $estudiante->constancias()->detach($constancia);
            $success = false;
        } else {
            $estudiante->constancias()->attach($constancia);
            $success = true;
        }
        return response()->json(['success' => $success]);
    }

    public function destroyEstudianteConstancia(Request $request, $idConstancia, $idEstudiante)
    {
        if($request->ajax()){
            $estudiante = Estudiante::findOrFail($idEstudiante);
            $constancia = Constancia::findOrFail($idConstancia);
            if ($estudiante->constancias()->where('Constancia.IdConstancia', $constancia->IdConstancia)->exists()) {
                $estudiante->constancias()->detach($constancia);
            }
            return response()->json(['success' => true]);
        } else {
            return redirect()->back();
        }
    }

    public function generarConstancia(Constancia $constancia, Estudiante $estudiante) 
    {
        $filename = 'c_' . str_pad($constancia->IdConstancia, 5, '0', STR_PAD_LEFT);
        $pathPlantilla = storage_path('app/constancias/' . $filename . '.docx');

        $templateProcessor = new TemplateProcessor($pathPlantilla);
        

        $templateProcessor->setValues([
            'nombre_estudiante'    => $estudiante->Usuario->DatosPersonales->ApellidoPaternoDatosPersonales . ' ' . 
                                      $estudiante->Usuario->DatosPersonales->ApellidoMaternoDatosPersonales . ' ' . 
                                      $estudiante->Usuario->DatosPersonales->NombreDatosPersonales,

            'matricula'            => $estudiante->MatriculaEstudiante,

            'programa_educativo'   => $estudiante->Trayectoria->ProgramaEducativo->NombreProgramaEducativo,

            'nombre_constancia'    => $constancia->NombreConstancia,

        ]);

        if ($constancia->VigenteHasta !== null) {
            $templateProcessor->setValue('vigencia',printDate($constancia->VigenteHasta));
        }
        else {
            $templateProcessor->setValue('vigencia','Indefinida');
        }

        // $pathQr = public_path('constancias plantilla/QR.jpg');
        $pathQr = storage_path('app/constancias/' . $constancia->IdConstancia);
        QrCode::size(200)
            ->style('round')
            ->format('png')
            ->generate(
                route('constancias.showEstudiante', [
                    'constancia' => $constancia->IdConstancia, 
                    'estudiante' => $estudiante->IdEstudiante
                ]),
                $pathQr
            );

        $templateProcessor->setImageValue(
            'codigo_qr', 
            [
                'path' => $pathQr,
                'width' => 200,
                'height' => 200,
                'ratio' => false,
            ]
        );

        $estudianteConstancia = $filename . "_" . $estudiante->MatriculaEstudiante;
        $pathEstudiante = storage_path('app/constancias/' . $estudianteConstancia);

        $templateProcessor->saveAs($pathEstudiante);

        exec('soffice --convert-to pdf '. $pathEstudiante .' --outdir ' . storage_path('app/constancias/'));

        // Eliminar archivos temporales
        unlink($pathEstudiante);
        unlink($pathQr);
        return response()->download($pathEstudiante . '.pdf')->deleteFileAfterSend(true);


        // Convertir a PDF
        // \PhpOffice\PhpWord\Settings::setPdfRendererPath(base_path('vendor/dompdf/dompdf/'));
        // \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        // $pdf = \PhpOffice\PhpWord\IOFactory::load($pathEstudiante); 
        // $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($pdf , 'PDF');
        // $xmlWriter->save($pathEstudiante . "pdf");  

        // Storage::delete($pathEstudiante);  // borrar archivo de word
        // return response()->download($pathEstudiante . "pdf")->deleteFileAfterSend(true);
    }
}
