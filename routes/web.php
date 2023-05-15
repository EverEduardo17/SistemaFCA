<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// DB::listen(function($query){
//     var_dump($query->sql);
// });

// Auth::loginUsingId(1001);

Auth::routes();


Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');


// Route::get('/login','auth\LoginController@login')->name('login');
Route::post('/login','auth\LoginController@success')->name('login');
Route::post('/logout','auth\LoginController@logout')->name('logout')->middleware('auth');


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

Route::get('/estudiantes-filtrar-grupos', 'EstudianteController@filtrarGrupos')->name('estudiantes.filtrarGrupos');

Route::resource('tipoorganizador', 'TipoOrganizadorController')->except('show', 'edit');

Route::resource('organizador', 'OrganizadorController');
Route::put('/fechaEvento/put', 'FechaEventoController@update')->name("fechaEventos.update");

//<---- Elimina los ids de las rutas ---->
Route::get('/empresas/{nombreEmpresa}', 'EmpresaController@show')->name('empresas.show');
Route::get('/empresas/{nombreEmpresa}/edit', 'EmpresaController@edit')->name('empresas.edit');

Route::get('/programaEducativo/{acronimoPrograma}/edit', 'ProgramaEducativoController@edit')->name('programaEducativo.edit');

Route::get('/eventos/{year}/{month}/{day}', 'EventoController@indexWithDate')->name("eventosWithDate");

// Route::post('/fechaEvento/store', 'FechaEventoController@store')->name("fechaEventos_store");

Route::delete('/fechaEvento/delete', 'FechaEventoController@destroy')->name('fechaeventos_delete');


//<---- Constancias ---->
Route::get('constancias/{IdConstancia}/download/{NombreConstancia}', 'ConstanciaController@downloadMiPlantilla')->name('constancias.downloadMiPlantilla');
Route::get('constancias/{IdConstancia}/downloadConstanciaGenerica', 'ConstanciaController@downloadConstanciaGenerica')->name('constancias.downloadGenerica');
Route::get('constancias/{constancia}/download/', 'ConstanciaController@downloadAllConstancias')->name('constancias.downloadAll');
Route::get('constancias/{constancia}/grupos', 'ConstanciaController@indexGrupos')->name('constancias.indexGrupos');
Route::get('constancias/{constancia}/grupos/{grupo}', 'ConstanciaController@indexEstudiantes')->name('constancias.indexEstudiantes');
Route::get('constancias/{constancia}/{estudiante}', 'ConstanciaController@showEstudiante')->name('constancias.showEstudiante');
Route::post('constancias/agregar-estudiante', 'ConstanciaController@addEstudianteConstancia')->name('constancias.addEstudiante');
Route::delete('constancias/{constancia}/delete/{estudiante}', 'ConstanciaController@destroyEstudianteConstancia')->name('constancias.destroyEstudiante');
Route::get('constancias/{constancia}/{estudiante}/download/', 'ConstanciaController@downloadConstancia')->name('constancias.download');
