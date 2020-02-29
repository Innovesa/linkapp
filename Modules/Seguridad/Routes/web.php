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

Route::prefix('seguridad')->group(function() {

        //usuarios
    
        Route::get('/usuarios', 'UsuarioController@index')->name('seguridad.usuarios');

        Route::get('/usuarios/cuadros', 'UsuarioController@verCuadros')->name('seguridad.usuarios.cuadros');

        Route::get('/usuarios/result/personas', 'UsuarioController@resultPersonas')->name('seguridad.usuarios.result.personas');
    
        Route::get('/usuarios/updatedata/{id}', 'UsuarioController@getUpdateData')->name('seguridad.usuarios.updateData');

        Route::get('/usuarios/createdata', 'UsuarioController@getCreateData')->name('seguridad.usuarios.createData');
    
        Route::get('/usuarios/eliminar/{id}', 'UsuarioController@eliminar')->name('seguridad.usuarios.eliminar');
    
        Route::get('/usuarios/activar/{id}', 'UsuarioController@activar')->name('seguridad.usuarios.activar');
    
        Route::get('/usuarios/desactivar/{id}', 'UsuarioController@desactivar')->name('seguridad.usuarios.desactivar');
    
        Route::post('/usuarios/create', 'UsuarioController@createUpdate')->name('seguridad.usuarios.create');

    
});
