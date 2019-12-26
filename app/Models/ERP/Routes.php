<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class Routes extends Model
{
    public static function ERP(){
        
        Route::get('/home','ERP\MenuController@index')->middleware('verified')->name('home');
        Route::get('/aplicacion/{idAplicacion}','ERP\MenuController@cambiarAplicacion')->name('aplicacion.cambiar');
        Route::get('/compania/{idCompania}','ERP\MenuController@cambiarCompania')->name('compania.cambiar');
        Route::get('/persona/image/{filename}', 'ERP\UsuarioController@getImage')->name('persona.image');
        Route::get('/usuario/verificacion/', 'ERP\UsuarioController@verificacionPerfil')->name('usuario.verificacion.perfil');
    }
}
