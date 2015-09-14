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
    $id = \App\Models\Video::count() - 1;
    $id = rand(0, $id);
    $video = \App\Models\Video::skip($id)->first();
    return redirect($video->id);
});


Route::get('user/{username}', 'UserController@show');
Route::get('logout', 'UserController@logout');
Route::post('login', 'UserController@login');
Route::get('register', 'UserController@create');
Route::post('register', 'UserController@store');
Route::get('activate/{token}', 'UserController@activate');
Route::get('songindex', 'VideoController@index');
Route::get('upload', 'VideoController@create');
Route::post('upload', 'VideoController@store');
Route::get('categories', 'CategoryController@index');

Route::get('{id}', 'VideoController@show')->where('id', '[0-9]+');
Route::post('{id}', 'VideoController@storeComment')->where('id', '[0-9]+');

Route::get('{shortname}', 'CategoryController@show')->where('shortname', '[a-z][a-z0-9]+');
Route::get('{shortname}/{id}', 'CategoryController@showVideo')->where(['shortname' => '[a-z][a-z0-9]+', 'id' => '[0-9]+']);
