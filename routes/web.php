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

Route::get('/', function () {
    return view('temes.inspinia.auth.login');
});

Auth::routes(['verify' => true]);

Route::get('/home','ERP\MenuController@index')->middleware('verified');
Route::get('/Prueba','ERP\MenuController@prueba')->name('prueba');

//Auth::routes();


