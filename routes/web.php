<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'PortalController');
Route::get('/post', 'PostController@index');
Route::post('/connection', 'ConnectionController@store');
Route::get('/connection', 'ConnectionController@show');
Route::delete('/connection', 'ConnectionController@destroy');
