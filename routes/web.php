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
Route::resource('facultades', 'FacultadController');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/eventos', 'EventoController@index')->name("eventos");
Route::get('/eventos/{year}/{month}/{day}', 'EventoController@indexWithDate')->name("eventosWithDate");
Route::get('/eventos/nuevo', 'EventoController@create')->name("eventos_create");
Route::post('eventos/nuevo', 'EventoController@store');
Route::get('eventos/{evento}', 'EventoController@show')->name("eventos_show");

Route::post('/fechaEvento/store', 'FechaEventoController@store')->name("fechaEventos_store");
Route::put('/fechaEvento/put', 'FechaEventoController@update')->name("fechaEventos_update");
Route::delete('/fechaEvento/delete', 'FechaEventoController@destroy')->name('fechaeventos_delete');

Route::get('/academicos', 'AcademicoController@index');

