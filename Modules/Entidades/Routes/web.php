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
    
    Route::get('/companias', 'CompaniaController@index')->name('entidades.companias');

    Route::get('/companias/cuadros', 'CompaniaController@verCuadros')->name('entidades.companias.cuadros');

    Route::get('/companias/updatedata/{id}', 'CompaniaController@getUpdateData')->name('entidades.companias.updateData');

    Route::get('/companias/eliminar/{id}', 'CompaniaController@eliminar')->name('entidades.companias.eliminar');

    Route::get('/companias/activar/{id}', 'CompaniaController@activar')->name('entidades.companias.activar');

    Route::get('/companias/desactivar/{id}', 'CompaniaController@desactivar')->name('entidades.companias.desactivar');

    Route::post('/companias/create', 'CompaniaController@createUpdate')->name('entidades.companias.create');
});
