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
    Route::post('/companias/create', 'CompaniaController@create')->name('entidades.companias.create');
});
