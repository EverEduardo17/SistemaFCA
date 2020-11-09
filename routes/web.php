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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('academias', 'AcademiaController');
Route::resource('academiaacademico', 'AcademiaAcademicoController');
Route::delete('academias/academico/delete/{academicoAcademia}', 'AcademiaController@destroyAcademicoAcademia')->name('deleteAcademicoAcademia');
Route::resource('academicos', 'AcademicoController');
Route::resource('academicoEvento','AcademicoEventoController')->except('index', 'create', 'show', 'edit', 'update');;
Route::resource('facultades', 'FacultadController')->except('show');
Route::resource('eventos', 'EventoController');
Route::resource('fechaEventos', 'FechaEventoController');
Route::resource('documento', 'DocumentoController');
<<<<<<< HEAD
Route::resource('sedeEventos', 'SedeEventoController');
Route::resource('tipoorganizador', 'TipoOrganizadorController');
=======
Route::resource('tipoorganizador', 'TipoOrganizadorController')->except('show', 'edit', 'destroy');
>>>>>>> a625e6847c17c04f27d8d60df1a1db91e4e6420a
Route::resource('organizador', 'OrganizadorController');
Route::put('/fechaEvento/put', 'FechaEventoController@update')->name("fechaEventos.update");

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/eventos/{year}/{month}/{day}', 'EventoController@indexWithDate')->name("eventosWithDate");

//Route::post('/fechaEvento/store', 'FechaEventoController@store')->name("fechaEventos_store");

Route::delete('/fechaEvento/delete', 'FechaEventoController@destroy')->name('fechaeventos_delete');

// Route::get('/academicos', 'AcademicoController@index');

