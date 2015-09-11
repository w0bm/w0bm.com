<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('video');
});


Route::get('user/{username}', 'UserController@show');
Route::get('logout', 'UserController@logout');
Route::post('login', 'UserController@login');
Route::get('register', 'UserController@create');
Route::post('register', 'UserController@store');


Route::get('upload', 'VideoController@create');
Route::post('upload', 'VideoController@store');

Route::get('{id}', 'VideoController@show');