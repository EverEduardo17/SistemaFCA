<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConstanciaRequest;
use App\Models\Constancia;
use App\Models\ConstanciaEvento;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpWord\TemplateProcessor;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class ConstanciaController extends Controller {
    /**
     * Muestra la lista de constancias.
     *
     * @return \Illuminate\Contracts\View\View La vista de la lista de constancias.
     * @throws \Illuminate\Auth\Access\AuthorizationException Si el usuario no tiene el permiso requerido.
     */
    public function index() {
        Gate::authorize('havepermiso', 'constancias-listar');

        $constancias = Constancia::with('usuario.datosPersonales')->get();
        return view('constancias.index', compact('constancias'));
    }

    /**
     * Muestra el formulario para crear una nueva constancia.
     *
     * @return \Illuminate\Contracts\View\View La vista del formulario de creación de constancias.
     * @throws \Illuminate\Auth\Access\AuthorizationException Si el usuario no tiene el permiso requerido.
     */
    public function create() {
        Gate::authorize('havepermiso', 'constancias-crear');

        return view('constancias.create');
    }

    /**
     * Almacena una nueva constancia en el sistema.
     *
     * @param \App\Http\Requests\ConstanciaRequest $request El objeto Request que contiene los datos de la constancia a almacenar.
     * @return \Illuminate\Http\RedirectResponse Una redirección a la página de índice de constancias.
     */
    public function store(ConstanciaRequest $request) {
        Gate::authorize('havepermiso', 'constancias-crear');

        $input = $request->validated();
        $timestamp = Carbon::now()->toDateTimeString();

        $vigenteHasta = null;
        if($input['VigenteHasta'] !== null) {
            $vigenteHasta = formatearDate($input['VigenteHasta']);
        }

        try {
            DB::beginTransaction();

            $datos = [
                'NombreConstancia' => $input['NombreConstancia'],
                'DescripcionConstancia' => $input['DescripcionConstancia'],
                'VigenteHasta' => $vigenteHasta,
                'EstadoConstancia' => 'PENDIENTE',
                'CreatedBy' => Auth::user()->IdUsuario,
                'CreatedAt' => $timestamp,
                'UpdatedAt' => $timestamp,
            ];

            $idConstanciaDB = DB::table('Constancia')->insertGetId($datos);

            DB::commit();

            $filename = 'c_'.str_pad($idConstanciaDB, 5, '0', STR_PAD_LEFT).'.docx';

            $plantilla = $request->file('Plantilla');
            $plantilla->storeAs('constancias/', $filename);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            Session::flash('flash', [['type' => "danger", 'message' => $throwable->getMessage()]]);
            // Session::flash('flash', [['type' => "danger", 'message' => "Error al registrar la constancia."]]);
            return redirect()->route('constancias.index');
        }

        $input['autor'] = Auth::user()->email;
        $this->enviarCorreos($input);

        Session::flash('flash', [['type' => "success", 'message' => "Constancia registrada correctamente."]]);
        return redirect()->route('constancias.index');
    }

    /**
     * Muestra los detalles de una constancia específica.
     *
     * @param \App\Models\Constancia $constancia La instancia del modelo Constancia a mostrar.
     * @return \Illuminate\Contracts\View\View La vista de detalles de constancias.
     */
    public function show(Constancia $constancia) {
        Gate::authorize('havepermiso', 'constancias-detalles');

        $usuarios = $constancia->usuarios;

        // Guardar los usuarios en la sesión para downloadAll()
        session()->put('usuarios', $usuarios);

        return view('constancias.show', compact('constancia', 'usuarios'));
    }

    /**
     * Muestra el formulario de edición para una constancia específica.
     *
     * @param \App\Models\Constancia $constancia La instancia del modelo Constancia a editar.
     * @return \Illuminate\Contracts\View\View La vista de edición de constancias.
     */
    public function edit(Constancia $constancia) {
        Gate::authorize('havepermiso', 'constancias-editar-propio');

        return view('constancias.edit', compact('constancia'));
    }

    /**
     * Actualiza los datos de una constancia.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Constancia $constancia La instancia del modelo Constancia a actualizar.
     * @return \Illuminate\Http\RedirectResponse La ruta Constancias.show una vez terminado el proceso.
     */
    public function update(Request $request, Constancia $constancia) {
        Gate::authorize('havepermiso', 'constancias-editar-propio');

        $timestamp = Carbon::now()->toDateTimeString();
        $vigenteHasta = null;

        $input = $request->validate([
            'NombreConstancia' => 'required | string',
            'DescripcionConstancia' => 'required | string',
            'VigenteHasta' => 'nullable | date_format:d/m/Y',
            'Plantilla' => 'nullable | file | mimes:doc,docx',
        ]);

        if($request->hasFile('Plantilla')) {
            $filename = 'c_'.str_pad($constancia->IdConstancia, 5, '0', STR_PAD_LEFT).'.docx';

            $request->file('Plantilla')->storeAs('constancias', $filename);
        }


        if($input['VigenteHasta'] !== null) {
            $vigenteHasta = formatearDate($input['VigenteHasta']);
        }
        try {
            DB::beginTransaction();

            $datos = [
                'NombreConstancia' => $input['NombreConstancia'],
                'DescripcionConstancia' => $input['DescripcionConstancia'],
                'VigenteHasta' => $vigenteHasta,
                'EstadoConstancia' => 'PENDIENTE',
                'Motivo' => null,
                'UpdatedAt' => $timestamp,
            ];

            // si la fecha no es nula, enviala a la BD
            if($vigenteHasta !== null) {
                $datos['VigenteHasta'] = $vigenteHasta;
            } else {
                $datos['VigenteHasta'] = null;
            }

            DB::table('Constancia')->where('IdConstancia', $constancia->IdConstancia)->update($datos);

            DB::commit();

            $constanciaEvento = ConstanciaEvento::find($constancia->IdConstancia);
            if($constanciaEvento) {
                $constanciaEvento->delete();
            }
        } catch (\Throwable $throwable) {
            DB::rollBack();
            Session::flash('flash', [['type' => "danger", 'message' => "Error, la constancia no pudo ser actualizada."]]);
            return redirect()->route('constancias.show', $constancia);
        }

        $input['autor'] = \App\Models\Usuario::find($constancia->CreatedBy)->email;
        $this->enviarCorreos($input);

        Session::flash('flash', [['type' => "success", 'message' => "Constancia actualizada con éxito."]]);
        return redirect()->route('constancias.show', $constancia);
    }

    /**
     * Elimina al estudiante del sistema.
     *
     * @param  \App\Models\Constancia  $constancia La instancia del modelo Constancia a eliminar.
     * @return \Illuminate\Http\RedirectResponse La ruta Constancias.index una vez terminado el proceso.
     */
    public function destroy(Constancia $constancia) {
        if(Auth::user()->IdUsuario === $constancia->CreatedBy) {
            if(!Auth::user()->can('havepermiso', 'constancias-eliminar-propio')) {
                Session::flash('flash', [['type' => "danger", 'message' => "No tiene autorización para eliminar sus constancias."]]);
                return redirect()->back();
            }
        } else {
            if(!Auth::user()->can('havepermiso', 'constancias-eliminar-cualquiera')) {
                Session::flash('flash', [['type' => "danger", 'message' => "No tiene autorización para eliminar constancias de otros."]]);
                return redirect()->back();
            }
        }

        try {
            $constancia->delete();
            Session::flash('flash', [['type' => "success", 'message' => "La constancia fue eliminada correctamente."]]);
            return redirect()->route('constancias.index');
        } catch (\Throwable $throwable) {
            Session::flash('flash', [['type' => "danger", 'message' => "La constancia NO pudo ser eliminada."]]);
            return redirect()->route('constancias.index');
        }
    }


    /**
     * Descarga la plantilla asociada a una constancia.
     * Se requiere el ID y el nombre de la constancia como parámetros.
     *
     * @param int $id El ID de la constancia.
     * @param string $nombreConstancia El nombre de la constancia.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse La respuesta de archivo binario que permite descargar la plantilla de la constancia.
     */
    public function downloadMiPlantilla($id, $nombreConstancia) {
        $filename = 'c_'.str_pad($id, 5, '0', STR_PAD_LEFT).'.docx';

        $pathToFile = storage_path('app/constancias/'.$filename);
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        return response()->download($pathToFile, ($nombreConstancia.'.docx'), $headers);
    }

    /**
     * Descargar una constancia génerica, que sirve de ejemplo de como usar este modulo.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadConstanciaGenerica() {
        $pathToFile = public_path('constancias plantilla/Plantilla.docx');
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        return response()->download($pathToFile, 'Plantilla.docx', $headers);
    }

    /**
     * Muestra la vista que contiene los datos de una constancia y del estudiante relacionado. 
     * Esta es la vista a la que se redirige cuando se escanea el código QR de la constancia.
     *
     * @param \App\Models\Constancia $constancia La instancia del modelo de Constancia.
     * @param \App\Models\Estudiante $usuario La instancia del modelo de Estudiante.
     * @return \Illuminate\Contracts\View\View La vista que muestra los datos de la constancia y el estudiante.
     */
    public function showEstudiante(Constancia $constancia, Usuario $usuario) {
        return view('constancias.estudiantes.showEstudiante', compact('constancia', 'usuario'));
    }

    /**
     * Muestra la lista de grupos al agregar un estudiante a una constancia.
     *
     * @param \App\Models\Constancia $constancia La instancia del modelo de Constancia.
     * @return \Illuminate\Contracts\View\View La vista que muestra la lista de grupos.
     * @throws \Illuminate\Auth\Access\AuthorizationException Si el usuario no tiene los permisos necesarios.
     */
    public function indexGrupos(Constancia $constancia) {
        Gate::authorize('havepermiso', 'constancias-detalles');

        $grupos = Grupo::all();
        return view('constancias.estudiantes.indexGrupos', compact('constancia', 'grupos'));
    }

    /**
     * Muestra la lista de estudiantes para un grupo específico dentro de una constancia.
     *
     * @param \App\Models\Constancia $constancia El objeto de la constancia relacionada.
     * @param \App\Models\Grupo $grupo El objeto del grupo del cual se mostrará la lista de estudiantes.
     * @return \Illuminate\Contracts\View\View La vista que muestra la lista de estudiantes.
     * @throws \Illuminate\Auth\Access\AuthorizationException Si el usuario no tiene los permisos necesarios.
     */
    public function indexEstudiantes(Constancia $constancia) {
        Gate::authorize('havepermiso', 'constancias-editar-propio');

        $usuarios = Usuario::all();

        return view('constancias.estudiantes.indexEstudiantes', compact('constancia', 'usuarios'));
    }

    /**
     * Agrega o elimina un estudiante de una constancia.
     * Si el estudiante ya está en la constancia, lo elimina. Este metodo es usado en indexEstudiantes.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse La respuesta JSON indica el resultado para poder hacer el cambio de manera reactiva con Javascript.
     */
    public function addEstudianteConstancia(Request $request) {
        Gate::authorize('havepermiso', 'constancias-editar-propio');

        $idUsuario = $request->input('idUsuario');
        $idConstancia = $request->input('idConstancia');
        $usuario = Usuario::findOrFail($idUsuario);
        $constancia = Constancia::findOrFail($idConstancia);

        if($usuario->constancias()->where('Constancia.IdConstancia', $constancia->IdConstancia)->exists()) {
            $usuario->constancias()->detach($constancia);
            $success = false;
        } 
        else {
            $usuario->constancias()->attach($constancia);
            $success = true;
        }
        return response()->json(['success' => $success]);
    }

    /**
     * Elimina la vinculación entre un estudiante y una constancia.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $idConstancia
     * @param  int $idEstudiante
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroyEstudianteConstancia(Request $request, $idConstancia, $idEstudiante) {
        Gate::authorize('havepermiso', 'constancias-eliminar-propio');

        if($request->ajax()) {
            $estudiante = Estudiante::findOrFail($idEstudiante);
            $constancia = Constancia::findOrFail($idConstancia);
            if($estudiante->constancias()->where('Constancia.IdConstancia', $constancia->IdConstancia)->exists()) {
                $estudiante->constancias()->detach($constancia);
            }
            return response()->json(['success' => true]);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Descarga la constancia generada para un estudiante en particular.
     *
     * @param  \App\Models\Constancia  $constancia
     * @param  \App\Models\Usuario  $usuario
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadConstancia(Constancia $constancia, Usuario $usuario) {
        if($constancia->EstadoConstancia != 'APROBADO') {
            Session::flash('flash', [['type' => "danger", 'message' => "Error: Intenta generar una constancia que no está aprobada."]]);
            return redirect()->back();
        }

        $pathConstancia = $this->generarConstancia($constancia, $usuario);

        return response()->download($pathConstancia)->deleteFileAfterSend(true);
    }

    /**
     * Descarga todas las constancias generadas para un tipo de constancia específico.
     *
     * @param  \Illuminate\Http\Request  $request  La instancia del objeto Request.
     * @param  \App\Models\Constancia  $constancia  La constancia para la cual se generarán los archivos.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse La respuesta de descarga del archivo ZIP o la redirección a la página anterior en caso de error.
     */
    public function downloadAllConstancias(Request $request, Constancia $constancia) {
        if($constancia->EstadoConstancia != 'APROBADO') {
            Session::flash('flash', [['type' => "danger", 'message' => "Error: Intenta generar una constancia que no está aprobada."]]);
            return redirect()->back();
        }

        $usuarios = $request->session()->get('usuarios');

        $allPaths = [];
        foreach($usuarios as $usuario) {
            $allPaths[] = $this->generarConstancia($constancia, $usuario);
        }

        $zip = new \ZipArchive();
        $zipFileName = $constancia->NombreConstancia.' constancias.zip';

        if($zip->open($zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            // Agregar cada archivo al ZIP
            foreach($allPaths as $path) {
                $zip->addFile($path, basename($path));
            }

            // Cerrar y guardar el ZIP
            $zip->close();

            // Eliminar los archivos temporales
            foreach($allPaths as $path) {
                unlink($path);
            }

            $request->session()->forget('usuarios');

            // Descargar el archivo ZIP
            return response()->download($zipFileName)->deleteFileAfterSend(true);
        }
        Session::flash('flash', [['type' => "danger", 'message' => "Error al generar el archivo ZIP."]]);
        return redirect()->back();
    }

    // Metodos auxiliares

    /**
     * Generar la constancia con PHPWord de un estudiante específico.
     *
     * @param Constancia $constancia La constancia para la cual se generará el archivo.
     * @param Usuario $usuario El usuario para el cual se generará la constancia.
     * @return string La ruta del archivo PDF generado.
     */
    public function generarConstancia(Constancia $constancia, Usuario $usuario) {
        $filename = 'c_'.str_pad($constancia->IdConstancia, 5, '0', STR_PAD_LEFT);
        $pathPlantilla = storage_path('app/constancias/'.$filename.'.docx');

        $templateProcessor = new TemplateProcessor($pathPlantilla);

        $sexo = $usuario->datosPersonales->Genero;

        $pronombre = ($sexo === 'Mujer') ? 'la' : 'el';
        $o_a = ($sexo === 'Mujer') ? 'a' : 'o';

        $templateProcessor->setValues([
            'nombre_participante' => $usuario->DatosPersonales->ApellidoPaternoDatosPersonales.' '.
                $usuario->DatosPersonales->ApellidoMaternoDatosPersonales.' '.
                $usuario->DatosPersonales->NombreDatosPersonales,

            'matricula' => $usuario->Estudiante->MatriculaEstudiante ?? $usuario->Academico->NoPersonalAcademico,

            'programa_educativo' => $usuario->Estudiante->Trayectoria->ProgramaEducativo->NombreProgramaEducativo ?? $usuario->password,

            'nombre_constancia' => $constancia->NombreConstancia,

            'el/la' => $pronombre,

            'o/a' => $o_a,

        ]);

        if($constancia->VigenteHasta !== null) {
            $templateProcessor->setValue('vigencia', printDate($constancia->VigenteHasta));
        } else {
            $templateProcessor->setValue('vigencia', 'Indefinida');
        }

        $users = Usuario::whereHas('roles', function ($query) {
            $query->where('ClaveRole', 'LIKE', 'DIRECCIÓN');
        })->get();

        if($users->count() !== 0) {
            $pathFirma = storage_path('app/public/uploads/'.$users[0]->academico->Firma);
            
            $templateProcessor->setImageValue(
                'img_firma',
                [
                    'path' => $pathFirma,
                    'width' => 150,
                    'height' => 150,
                    'ratio' => true,
                ]
            );

            $nombre = $users[0]->datosPersonales->NombreDatosPersonales;
            $apellidoPaterno = $users[0]->datosPersonales->ApellidoPaternoDatosPersonales;
            $apellidoMaterno = $users[0]->datosPersonales->ApellidoMaternoDatosPersonales;

            $templateProcessor->setValue('nombre_direccion', "$nombre $apellidoPaterno $apellidoMaterno");
        }
        else {
            $templateProcessor->setValue('nombre_direccion', "Error: No se encontró ningún director en el sistema, contacte al administrador.");
            $templateProcessor->setValue('img_firma', "__");
        }

        // $pathQr = public_path('constancias plantilla/QR.jpg');
        $pathQr = storage_path('app/constancias/'.$constancia->IdConstancia);
        QrCode::size(200)
            ->style('round')
            ->format('png')
            ->generate(
                route('constancias.showEstudiante', [
                    'constancia' => $constancia->IdConstancia,
                    'usuario' => $usuario->IdUsuario
                ]),
                $pathQr
            );

        $templateProcessor->setImageValue(
            'codigo_qr',                    // busca la palabra codigo_qr en la plantilla
            [
                'path' => $pathQr,
                'width' => 100,
                'height' => 100,
                'ratio' => false,
            ]
        );

        $estudianteConstancia = $filename."_".$usuario->name;
        $pathEstudiante = storage_path('app/constancias/'.$estudianteConstancia.'.docx');

        $templateProcessor->saveAs($pathEstudiante);

        // Libreoffice convertir a pdf
        // exec('soffice --convert-to pdf '. $pathEstudiante .' --outdir ' . storage_path('app/constancias/'));
        // exec("docto -f $pathEstudiante -O ". storage_path('app/constancias/') . " -T wdFormatPDF");

        //perfil de usuario temporal para soffice, por los permisos de /var/www/
        // $tempLibreOfficeProfile = sys_get_temp_dir() . "/LibreOfficeProfile" . rand(100000, 999999);
        // $cmd = 'soffice "-env:UserInstallation=file:///' . str_replace("\\", "/", $tempLibreOfficeProfile) . '" --convert-to pdf ' . $pathEstudiante . ' --outdir ' . storage_path('app/constancias/');
        // exec($cmd);


        // Eliminar archivos temporales
        // unlink($pathEstudiante);
        unlink($pathQr);

        return $pathEstudiante;
    }

    /**
     * Consulta las constancias que esperan aprobación y renderiza la vista 'aprobar'.
     *
     * @return \Illuminate\View\View La vista de la lista de constancias pendientes de aprobación.
     */
    public function indexAprobar() {
        Gate::authorize('havepermiso', 'constancias-aprobar-rechazar');

        $constancias = Constancia::with('usuario.datosPersonales')->where('EstadoConstancia', 'Pendiente')->get();

        return view('constancias.aprobar', compact('constancias'));
    }

    /**
     * Aprobar una Constancia.
     *
     * @param int $id El ID de la Constancia a aprobar.
     * @throws \Throwable Si ocurre un error durante el proceso.
     * @return \Illuminate\Http\RedirectResponse La respuesta de redirección a la página de aprobación de constancia.
     */
    public function aprobarConstancia($id) {
        Gate::authorize('havepermiso', 'constancias-aprobar-rechazar');

        try {
            $constancia = Constancia::find($id);
            $constancia->EstadoConstancia = 'APROBADO';
            $constancia->save();
            Session::flash('flash', [['type' => "success", 'message' => "La constancia fue aprobada correctamente."]]);
        } catch (\Throwable $th) {
            Session::flash('flash', [['type' => "danger", 'message' => "La constancia NO pudo ser aprobada."]]);
        }

        return redirect()->back();
    }

    /**
     * Rechaza una constancia.
     *
     * @param int $id El ID de la constancia.
     * @throws \Throwable Si ocurre un error durante el proceso.
     * @return \Illuminate\Http\RedirectResponse La respuesta de redirección a la página de aprobación de constancias.
     */
    public function rechazarConstancia(Request $request, $id) {
        Gate::authorize('havepermiso', 'constancias-aprobar-rechazar');

        $motivo = $request->get('Motivo');

        if(empty($motivo) || strlen(trim($motivo)) > 255) {
            Session::flash('flash', [['type' => "danger", 'message' => "El motivo es requerido."]]);
            return redirect()->back();
        }

        try {
            $constancia = Constancia::find($id);
            $constancia->EstadoConstancia = 'NO APROBADO';
            $constancia->Motivo = $motivo;
            $constancia->save();
            Session::flash('flash', [['type' => "success", 'message' => "La constancia fue rechazada correctamente."]]);
        } catch (\Throwable $th) {
            Session::flash('flash', [['type' => "danger", 'message' => "La constancia NO pudo ser rechazada."]]);
        }

        return redirect()->back();
    }

    /**
     * Manda un correo con los datos de la constancia para solicitar aprobación
     *
     * @param array $input
     * @return void
     */
    private function enviarCorreos($input) {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("zs18015382@estudiantes.uv.mx", "SistemaFCA Constancias");
        $email->setSubject('Solicitud de aprobación para "'.$input['NombreConstancia'].'"');
        $email->addContent(
            "text/html",
            view('emails.constancia-registrada')->with('input', $input)->render()
        );
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

        $users = Usuario::whereHas('roles', function ($query) {
            $query->where('ClaveRole', 'LIKE', 'CONTROL-GÉNERAL')
                ->orWhere('ClaveRole', 'LIKE', 'CONTROL-CONSTANCIAS');
        })->get();

        foreach($users as $user) {
            $email->addTo($user->email, $user->name);
            $response = $sendgrid->send($email);
        }
    }
}
