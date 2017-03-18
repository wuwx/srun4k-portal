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

Route::get('/', 'PortalController');
Route::get('/post', 'PostController@index');
Route::post('/connection', 'ConnectionController@store');
Route::get('/connection', 'ConnectionController@show');
Route::delete('/connection', 'ConnectionController@destroy');

Route::get('/mobile', function () {
    return view('mobile');
});
