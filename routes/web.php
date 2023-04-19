<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;

// DB::listen(function($query){
//     var_dump($query->sql);
// });

Auth::loginUsingId(1001);

Auth::routes();

Route::resource('academias', 'AcademiaController');
Route::resource('academiaacademico', 'AcademiaAcademicoController');
Route::delete('academias/academico/delete/{academicoAcademia}', 'AcademiaController@destroyAcademicoAcademia')->name('deleteAcademicoAcademia');
Route::resource('academicos', 'AcademicoController');
Route::resource('academicoEvento', 'AcademicoEventoController')->except('index', 'create', 'show', 'edit', 'update');
Route::resource('bajas', 'BajaController')->except('show', 'create');
Route::resource('cohortes', 'CohorteController');
Route::resource('constancias', 'ConstanciaController');
Route::resource('documento', 'DocumentoController');
Route::resource('estudiantes', 'EstudianteController');
Route::resource('empresas', 'EmpresaController')->except('show', 'edit');
Route::resource('eventos', 'EventoController');
Route::resource('facultades', 'FacultadController')->except('show');
Route::resource('fechaEventos', 'FechaEventoController');
Route::resource('grupos', 'GrupoController');
Route::resource('periodo', 'PeriodoController');
Route::resource('practicas', 'PracticasEstudianteController');
Route::resource('programaEducativo', 'ProgramaEducativoController')->except('show','edit');
Route::resource('reprobado', 'ReprobadoController');
Route::resource('sedeEventos', 'SedeEventoController');
Route::resource('servicio', 'ServicioSocialEstudianteController');
Route::resource('titulo', 'TitulacionController');
Route::resource('traslado', 'TrasladoController');
Route::resource('sedeEventos', 'SedeEventoController');
Route::resource('eventos.estado', 'EventoEstadoController')->shallow();
Route::post('eventos/{evento}/estado/rechado', 'EventoEstadoController@rechazo')->name('eventos.estado.rechazo');
Route::post('eventos/{evento}/estado/cancelar', 'EventoEstadoController@cancelar')->name('eventos.estado.cancelar');


Route::resource('tipoorganizador', 'TipoOrganizadorController')->except('show', 'edit');

Route::resource('organizador', 'OrganizadorController');
Route::put('/fechaEvento/put', 'FechaEventoController@update')->name("fechaEventos.update");

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

//<---- Elimina los ids de las rutas ---->
Route::get('/empresas/{nombreEmpresa}', 'EmpresaController@show')->name('empresas.show');
Route::get('/empresas/{nombreEmpresa}/edit', 'EmpresaController@edit')->name('empresas.edit');

Route::get('/programaEducativo/{acronimoPrograma}/edit', 'ProgramaEducativoController@edit')->name('programaEducativo.edit');
//TODO: Preguntar de la ruta de los grupos
//Propuesta .../{cohorte}/{ProgramaEducativo}/{nombreGrupo}

//<---- Detalles de los Cohortes ---->
Route::get('/cohortes', 'CohorteController@mostrarCohorte')->name('cohortes.mostrarCohorte');
Route::get('/cohortes/{nombreCohorte}/resumen', 'CohorteController@mostrarResumen')->name('cohortes.mostrarResumen');
Route::get('/cohortes/{nombreCohorte}/resumen/imprimir', 'CohorteController@imprimirResumen')->name('cohortes.imprimirResumenCohorte');
Route::get('/cohortes/{nombreCohorte}/estado', 'CohorteController@mostrarEstado')->name('cohortes.mostrarEstadoCohorte');
Route::get('/cohortes/{nombreCohorte}/estado/imprimir', 'CohorteController@imprimirEstado')->name('cohortes.imprimirEstadoCohorte');
Route::get('/cohortes/{nombreCohorte}/egresados', 'CohorteController@mostrarEgresados')->name('cohortes.mostrarEgresadosCohorte');
Route::get('/cohortes/{nombreCohorte}/egresados/imprimir', 'CohorteController@imprimirEgresados')->name('cohortes.imprimirEgresadosCohorte');
Route::get('/cohortes/{nombreCohorte}/traslados', 'CohorteController@mostrarTraslados')->name('cohortes.mostrarTrasladosCohorte');
Route::get('/cohortes/{nombreCohorte}/traslados/imprimir', 'CohorteController@imprimirTraslados')->name('cohortes.imprimirTrasladosCohorte');
Route::get('/cohortes/{nombreCohorte}/reprobados', 'CohorteController@mostrarReprobados')->name('cohortes.mostrarReprobadosCohorte');
Route::get('/cohortes/{nombreCohorte}/reprobados/imprimir', 'CohorteController@imprimirReprobados')->name('cohortes.imprimirReprobadosCohorte');
Route::get('/cohortes/{nombreCohorte}/bajas', 'CohorteController@mostrarBajas')->name('cohortes.mostrarBajasCohorte');

//<---- Importar archivo de Excel ---->
Route::post('/cohortes/importar', 'ImportarController@store')->name('cohortes.importarCohorte');
//TODO: Preguntar de esto, cómo mandar los valores.
Route::post('/cohortes/importar/finalizar', 'ImportarController@save')->name('cohortes.guardarImporte');
Route::get('/cohortes/importar/{nombreArchivo}/cancelar', 'ImportarController@cancel')->name('cohortes.cancelarImporte');

//<---- Detalles de los Grupos ---->
Route::get('/cohortes/{nombreCohorte}/{nombreGrupo}/agregar', 'CohorteController@agregarEstudiante')->name('cohortes.agregarEstudiante');
Route::get('/cohortes/{nombreCohorte}/{nombreGrupo}', 'GrupoController@mostrarGrupo')->name('cohortes.mostrarGrupo');
Route::get('/cohortes/{nombreCohorte}/{nombreGrupo}/imprimir', 'GrupoController@imprimirGrupo')->name('cohortes.imprimirGrupo');
Route::get('/cohortes/{nombreCohorte}/{nombreGrupo}/estado', 'GrupoController@mostrarEstado')->name('cohortes.mostrarEstado');
Route::get('/cohortes/{nombreCohorte}/{nombreGrupo}/estado/imprimir', 'GrupoController@imprimirEstado')->name('cohortes.imprimirEstado');
Route::get('/cohortes/{nombreCohorte}/{nombreGrupo}/egresados', 'GrupoController@mostrarEgresados')->name('cohortes.mostrarEgresados');
Route::get('/cohortes/{nombreCohorte}/{nombreGrupo}/egresados/imprimir', 'GrupoController@imprimirEgresados')->name('cohortes.imprimirEgresados');
Route::get('/cohortes/{nombreCohorte}/{nombreGrupo}/egresados/{nombrePeriodo}', 'GrupoController@mostrarEgresadosPeriodo')->name('cohortes.mostrarEgresados.periodo');
Route::get('/cohortes/{nombreCohorte}/{nombreGrupo}/traslados', 'GrupoController@mostrarTraslados')->name('cohortes.mostrarTraslados');
Route::get('/cohortes/{nombreCohorte}/{nombreGrupo}/traslados/imprimir', 'GrupoController@imprimirTraslados')->name('cohortes.imprimirTraslados');
Route::get('/cohortes/{nombreCohorte}/{nombreGrupo}/reprobados', 'GrupoController@mostrarReprobados')->name('cohortes.mostrarReprobados');
Route::get('/cohortes/{nombreCohorte}/{nombreGrupo}/reprobados/imprimir', 'GrupoController@imprimirReprobados')->name('cohortes.imprimirReprobados');
Route::get('/cohortes/{nombreCohorte}/{nombreGrupo}/reprobados/{nombrePeriodo}', 'GrupoController@mostrarReprobadosPeriodo')->name('cohortes.mostrarReprobados.periodo');
Route::get('/cohortes/{nombreCohorte}/{nombreGrupo}/bajas', 'GrupoController@mostrarBajas')->name('cohortes.mostrarBajas');
Route::get('/cohortes/{nombreCohorte}/{nombreGrupo}/bajas/imprimir', 'GrupoController@imprimirBajas')->name('cohortes.imprimirBajas');

//<---- Grupos ---->
Route::get('grupos/{idGrupo}/estudiantes', 'GrupoController@indexEstudiantes')->name('grupos.estudiantes');
Route::get('grupos/{idGrupo}/estudiantes/agregar', 'EstudianteController@agregarEstudiante')->name('grupos.agregarEstudiante');
Route::get('grupos/{idGrupo}/estudiantes/{matriculaEstudiante}', 'GrupoController@showEstudiante')->name('grupos.showEstudiante');
Route::get('grupos/{idGrupo}/estudiantes/{idEstudiante}/editar', 'GrupoController@editarEstudiante')->name('grupos.editarEstudiante');

Route::get('/eventos/{year}/{month}/{day}', 'EventoController@indexWithDate')->name("eventosWithDate");

// Route::post('/fechaEvento/store', 'FechaEventoController@store')->name("fechaEventos_store");

Route::delete('/fechaEvento/delete', 'FechaEventoController@destroy')->name('fechaeventos_delete');


//<---- Constancias ---->
Route::get('constancias/{IdConstancia}/download/{NombreConstancia}', 'ConstanciaController@downloadConstancia')->name('constancias.download');
Route::get('constancias/{IdConstancia}/downloadConstanciaGenerica', 'ConstanciaController@downloadConstanciaGenerica')->name('constancias.downloadGenerica');
Route::get('constancias/{constancia}/grupos', 'ConstanciaController@indexGrupos')->name('constancias.indexGrupos');
Route::get('constancias/{constancia}/grupos/{grupo}', 'ConstanciaController@indexEstudiantes')->name('constancias.indexEstudiantes');
Route::get('constancias/{constancia}/{estudiante}', 'ConstanciaController@showEstudiante')->name('constancias.showEstudiante');
Route::post('constancias/agregar-estudiante', 'ConstanciaController@addEstudianteConstancia')->name('constancias.addEstudiante');
Route::delete('constancias/{constancia}/delete/{estudiante}', 'ConstanciaController@destroyEstudianteConstancia')->name('constancias.destroyEstudiante');
Route::get('constancias/{constancia}/{estudiante}/download/', 'ConstanciaController@generarConstancia')->name('constancias.generar');


