<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// DB::listen(function($query){
//     var_dump($query->sql);
// });

Auth::loginUsingId(1001);

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/login','auth\LoginController@login')->name('login');
Route::post('/login','auth\LoginController@attempt')->name('login');
Route::get('/logout','auth\LoginController@logout')->name('logout')->middleware('auth');
Route::get('/callback', 'auth\LoginController@callback');

//Pendiente de validacion (uso)
Route::resource('academias', 'AcademiaController');
Route::resource('academiaacademico', 'AcademiaAcademicoController');
Route::delete('academias/academico/delete/{academicoAcademia}', 'AcademiaController@destroyAcademicoAcademia')->name('deleteAcademicoAcademia');
Route::resource('bajas', 'BajaController')->except('show', 'create');
Route::resource('facultades', 'FacultadController')->except('show');
Route::resource('programaEducativo', 'ProgramaEducativoController')->except('show','edit');
Route::get('/programaEducativo/{acronimoPrograma}/edit', 'ProgramaEducativoController@edit')->name('programaEducativo.edit');
Route::resource('empresas', 'EmpresaController')->except('show', 'edit');
Route::get('/empresas/{nombreEmpresa}', 'EmpresaController@show')->name('empresas.show');
Route::get('/empresas/{nombreEmpresa}/edit', 'EmpresaController@edit')->name('empresas.edit');
Route::resource('cohortes', 'CohorteController');
Route::resource('grupos', 'GrupoController');
Route::resource('periodo', 'PeriodoController');
Route::resource('practicas', 'PracticasEstudianteController');
Route::resource('reprobado', 'ReprobadoController');
Route::resource('servicio', 'ServicioSocialEstudianteController');
Route::resource('titulo', 'TitulacionController');
Route::resource('traslado', 'TrasladoController');

//Revisado
Route::resource('sedeEventos', 'SedeEventoController');
Route::resource('tipoorganizador', 'TipoOrganizadorController')->except('show', 'edit');


//Pendiente Revissar
Route::resource('academicos', 'AcademicoController');
Route::resource('estudiantes', 'EstudianteController');
Route::resource('academicoEvento', 'AcademicoEventoController')->except('index', 'create', 'show', 'edit', 'update');


//No mover 'constancias/aprobar/' por debajo de Route::resource('constancias', 'ConstanciaController');
Route::get('constancias/aprobar/', 'ConstanciaController@indexAprobar')->name('constancias.aprobar');
Route::resource('eventos', 'EventoController');
Route::resource('constancias', 'ConstanciaController');
Route::resource('documento', 'DocumentoController');
Route::resource('fechaEventos', 'FechaEventoController');
Route::resource('eventos.estado', 'EventoEstadoController')->shallow();
Route::post('eventos/{evento}/estado/rechado', 'EventoEstadoController@rechazo')->name('eventos.estado.rechazo');
Route::post('eventos/{evento}/estado/cancelar', 'EventoEstadoController@cancelar')->name('eventos.estado.cancelar');
Route::post('eventos/{evento}/constancias/añadir','ConstanciaEventoController@store')->name('eventos.constancias.añadir');
Route::post('eventos/{evento}/constancias/eliminar','ConstanciaEventoController@destroy')->name('eventos.constancias.eliminar');

Route::get('/estudiantes-filtrar-grupos', 'EstudianteController@filtrarGrupos')->name('estudiantes.filtrarGrupos');

Route::resource('organizador', 'OrganizadorController');
Route::put('/fechaEvento/put', 'FechaEventoController@update')->name("fechaEventos.update");

// Route::post('/fechaEvento/store', 'FechaEventoController@store')->name("fechaEventos_store");

Route::delete('/fechaEvento/delete', 'FechaEventoController@destroy')->name('fechaeventos_delete');

//<---- Constancias ---->
Route::get('constancias/{IdConstancia}/download/{NombreConstancia}', 'ConstanciaController@downloadMiPlantilla')->name('constancias.downloadMiPlantilla');
Route::get('constancias/0/downloadConstanciaGenerica', 'ConstanciaController@downloadConstanciaGenerica')->name('constancias.downloadGenerica');
Route::get('constancias/{constancia}/download/', 'ConstanciaController@downloadAllConstancias')->name('constancias.downloadAll');
Route::get('constancias/{constancia}/grupos', 'ConstanciaController@indexGrupos')->name('constancias.indexGrupos');
Route::get('constancias/{constancia}/usuarios/', 'ConstanciaController@indexEstudiantes')->name('constancias.indexEstudiantes');
Route::get('constancias/{constancia}/{usuario}', 'ConstanciaController@showEstudiante')->name('constancias.showEstudiante');
Route::post('constancias/agregar-estudiante', 'ConstanciaController@addEstudianteConstancia')->name('constancias.addEstudiante');
Route::delete('constancias/{constancia}/delete/{usuario}', 'ConstanciaController@destroyEstudianteConstancia')->name('constancias.destroyEstudiante');
Route::get('constancias/{constancia}/{usuario}/download/', 'ConstanciaController@downloadConstancia')->name('constancias.download');
Route::get('constancias/aprobar/{id}/aprobar', 'ConstanciaController@aprobarConstancia')->name('constancias.aprobar.aceptar');
Route::get('constancias/aprobar/{id}/rechazar', 'ConstanciaController@rechazarConstancia')->name('constancias.aprobar.rechazar');

//<---- Roles ---->
Route::post('usuarios/roles/agregar-rol', 'AcademicoController@addRole')->name('usuario.add.role');
Route::get('{usuario}/roles', 'AcademicoController@indexRoles')->name('usuario.index.roles');

//<---- Ayuda ---->
Route::get('/ayuda', 'ManualesController@index')->name('ayuda');

Route::get("/test", function (){
  phpinfo();
});
