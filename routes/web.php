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

<<<<<<< HEAD

=======
>>>>>>> 1798476cb12c7add1b4cc7bf6406b5a918e9e377
Route::get('/home', function () {
    return view('temes.inspinia.test.test');
})->middleware('verified');

//Auth::routes();


