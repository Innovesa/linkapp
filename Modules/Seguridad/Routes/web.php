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

        Route::post('/usuarios/updatePassword', 'UsuarioController@updatePassword')->name('seguridad.usuarios.update.password');
    
        Route::get('/usuarios/eliminar/{id}', 'UsuarioController@eliminar')->name('seguridad.usuarios.eliminar');
    
        Route::get('/usuarios/activar/{id}', 'UsuarioController@activar')->name('seguridad.usuarios.activar');
    
        Route::get('/usuarios/desactivar/{id}', 'UsuarioController@desactivar')->name('seguridad.usuarios.desactivar');
    
        Route::post('/usuarios/create', 'UsuarioController@createUpdate')->name('seguridad.usuarios.create');

        
        //perfiles
    
        Route::get('/perfiles', 'PerfilController@index')->name('seguridad.perfiles');

        Route::get('/perfiles/cuadros', 'PerfilController@verCuadros')->name('seguridad.perfiles.cuadros');

        Route::get('/perfiles/result/personas', 'PerfilController@resultPersonas')->name('seguridad.perfiles.result.personas');
    
        Route::get('/perfiles/updatedata/{id}', 'PerfilController@getUpdateData')->name('seguridad.perfiles.updateData');

        Route::get('/perfiles/createdata', 'PerfilController@getCreateData')->name('seguridad.perfiles.createData');

        Route::post('/perfiles/updatePassword', 'PerfilController@updatePassword')->name('seguridad.perfiles.update.password');
    
        Route::get('/perfiles/eliminar/{id}', 'PerfilController@eliminar')->name('seguridad.perfiles.eliminar');
    
        Route::get('/perfiles/activar/{id}', 'PerfilController@activar')->name('seguridad.perfiles.activar');
    
        Route::get('/perfiles/desactivar/{id}', 'PerfilController@desactivar')->name('seguridad.perfiles.desactivar');
    
        Route::post('/perfiles/create', 'PerfilController@createUpdate')->name('seguridad.perfiles.create');

    
});
