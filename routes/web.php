<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::loginUsingId(1001);

//Route::get('/home', function () {
 //   return view('welcome');
//});

Auth::routes();

Route::resource('academias', 'AcademiaController');
Route::resource('academiaacademico', 'AcademiaAcademicoController');
Route::delete('academias/academico/delete/{academicoAcademia}', 'AcademiaController@destroyAcademicoAcademia')->name('deleteAcademicoAcademia');
Route::resource('academicos', 'AcademicoController');
Route::resource('academicoEvento','AcademicoEventoController')->except('index', 'create', 'show', 'edit', 'update');
Route::resource('bajas', 'BajaController');
Route::resource('cohortes', 'CohorteController');
Route::resource('documento', 'DocumentoController');
Route::resource('estudiantes', 'EstudianteController');
Route::resource('empresas', 'EmpresaController');
Route::resource('eventos', 'EventoController');
Route::resource('facultades', 'FacultadController')->except('show');
Route::resource('fechaEventos', 'FechaEventoController');
Route::resource('grupos', 'GrupoController');
Route::resource('periodo', 'PeriodoController');
Route::resource('programaEducativo', 'ProgramaEducativoController');
Route::resource('sedeEventos', 'SedeEventoController');

Route::resource('tipoorganizador', 'TipoOrganizadorController')->except('show', 'edit');

Route::resource('organizador', 'OrganizadorController');
Route::put('/fechaEvento/put', 'FechaEventoController@update')->name("fechaEventos.update");

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/cohortes/{nombreCohorte}/{idGrupo}', 'GrupoController@mostrarGrupo')->name('cohortes.mostrarGrupo');
Route::get('/cohortes/{nombreCohorte}/{idGrupo}/estado', 'GrupoController@mostrarEstado')->name('cohortes.mostrarEstado');

Route::get('grupos/{idGrupo}/estudiantes', 'EstudianteController@show')->name('estudiantesGrupo');
Route::get('grupos/{idGrupo}/estudiantes/{idEstudiante}', 'EstudianteController@mostrarEstudiante')->name('mostrarEstudiante');

Route::get('/eventos/{year}/{month}/{day}', 'EventoController@indexWithDate')->name("eventosWithDate");

// Route::post('/fechaEvento/store', 'FechaEventoController@store')->name("fechaEventos_store");

Route::delete('/fechaEvento/delete', 'FechaEventoController@destroy')->name('fechaeventos_delete');



