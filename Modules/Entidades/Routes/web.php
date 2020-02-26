<?php

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

Route::prefix('entidades')->group(function() {

    //Companias
    
    Route::get('/companias', 'CompaniaController@index')->name('entidades.companias');

    Route::get('/companias/cuadros', 'CompaniaController@verCuadros')->name('entidades.companias.cuadros');

    Route::get('/companias/updatedata/{id}', 'CompaniaController@getUpdateData')->name('entidades.companias.updateData');

    Route::get('/companias/eliminar/{id}', 'CompaniaController@eliminar')->name('entidades.companias.eliminar');

    Route::get('/companias/activar/{id}', 'CompaniaController@activar')->name('entidades.companias.activar');

    Route::get('/companias/desactivar/{id}', 'CompaniaController@desactivar')->name('entidades.companias.desactivar');

    Route::post('/companias/create', 'CompaniaController@createUpdate')->name('entidades.companias.create');

    //Personas
    
    Route::get('/personas', 'PersonaController@index')->name('entidades.personas');

    Route::get('/personas/cuadros', 'PersonaController@verCuadros')->name('entidades.personas.cuadros');

    Route::get('/personas/updatedata/{id}', 'PersonaController@getUpdateData')->name('entidades.personas.updateData');

    Route::get('/personas/eliminar/{id}', 'PersonaController@eliminar')->name('entidades.personas.eliminar');

    Route::get('/personas/activar/{id}', 'PersonaController@activar')->name('entidades.personas.activar');

    Route::get('/personas/desactivar/{id}', 'PersonaController@desactivar')->name('entidades.personas.desactivar');

    Route::post('/personas/create', 'PersonaController@createUpdate')->name('entidades.personas.create');

    //Sedes
    
    Route::get('/sedes', 'SedeController@index')->name('entidades.sedes');

    Route::get('/sedes/cuadros', 'SedeController@verCuadros')->name('entidades.sedes.cuadros');

    Route::get('/sedes/updatedata/{id}', 'SedeController@getUpdateData')->name('entidades.sedes.updateData');

    Route::get('/sedes/eliminar/{id}', 'SedeController@eliminar')->name('entidades.sedes.eliminar');

    Route::get('/sedes/activar/{id}', 'SedeController@activar')->name('entidades.sedes.activar');

    Route::get('/sedes/desactivar/{id}', 'SedeController@desactivar')->name('entidades.sedes.desactivar');

    Route::post('/sedes/create', 'SedeController@createUpdate')->name('entidades.sedes.create');
});
