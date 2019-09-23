<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class Routes extends Model
{
    public static function ERP(){
        
        Route::get('/{aplicacion}/home','ERP\MenuController@index')->middleware('verified')->name('home');
        Route::get('/{aplicacion}/prueba','ERP\MenuController@prueba')->name('prueba');
        Route::get('/user/avatar/{filename}', 'ERP\UsuarioController@getImage')->name('usuario.avatar');
    }
}
