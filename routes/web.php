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
Route::resource('academicos', 'AcademicoController');
Route::resource('academicoEvento','AcademicoEventoController');
Route::resource('facultades', 'FacultadController');
Route::resource('eventos', 'EventoController');
Route::resource('fechaEventos', 'FechaEventoController');
Route::put('/fechaEvento/put', 'FechaEventoController@update')->name("fechaEventos.update");

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/eventos/{year}/{month}/{day}', 'EventoController@indexWithDate')->name("eventosWithDate");

//Route::post('/fechaEvento/store', 'FechaEventoController@store')->name("fechaEventos_store");

Route::delete('/fechaEvento/delete', 'FechaEventoController@destroy')->name('fechaeventos_delete');

// Route::get('/academicos', 'AcademicoController@index');

