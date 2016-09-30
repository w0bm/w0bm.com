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

Route::get('/', ['as' => 'home', function () {
    Session::reflash();

    if(auth()->check()) {
        $id = \App\Models\Video::whereIn('category_id', auth()->user()->categories)->count() - 1;
        $id = mt_rand(0, $id);
        $video = \App\Models\Video::whereIn('category_id', auth()->user()->categories)->skip($id)->first();

        return redirect($video->id);
    }

    $id = App\Models\Video::count() - 1;
    $id = mt_rand(0, $id);
    $video = App\Models\Video::skip($id)->first();
    return redirect($video->id);
}]);


Route::get('messages', 'MessageController@page');
Route::get('user/{username}', 'UserController@show');
Route::get('user/{username}/favs', 'UserController@show_favs');
Route::get('user/{username}/comments', 'UserController@show_comments');
Route::get('logout', 'UserController@logout');
Route::post('login', 'UserController@login');
Route::get('register', 'UserController@create');
Route::post('register', 'UserController@store');
Route::get('activate/{token}', 'UserController@activate');
Route::get('songindex', 'VideoController@index');
Route::post('songindex/{id}', 'VideoController@update');
Route::get('upload', 'VideoController@create');
Route::get('categories', 'CategoryController@index');
Route::get('webm', function() { return view('webm'); });
Route::get('about', function() { return view('about'); });
Route::get('irc', function() { return view('irc'); });
Route::get('rules', function() { return view('rules'); });
Route::get('contact', function() { return view('contact'); });
Route::get('privacy', function() { return view('privacy'); });
Route::get('help', function() { return view('help'); });
Route::get('map', function() { return view('map'); });
Route::get('donate', function() { return view('donate'); });
Route::get('transparency', function() { return view('transparency'); });
Route::get('login', function() { return view('login'); });

Route::post('filter', 'UserController@filter');

// /api
Route::group(['prefix' => 'api'], function() {

    // /api/messages
    Route::group(['prefix' => 'messages'], function() {
        Route::get('', 'MessageController@index');
        Route::post('read', 'MessageController@read');
        Route::get('readall', 'MessageController@readall');
    });

    // /api/comments
    Route::group(['prefix' => 'comments'], function() {
        Route::get('/', 'CommentController@index');
        Route::get('/{id}', 'CommentController@show')->where('id', '[0-9]+');
        Route::post('{id}/edit', 'CommentController@update')->where('id', '[0-9]+');
        Route::post('{id}/delete', 'CommentController@destroy')->where('id', '[0-9]+');
        Route::post('{id}/restore', 'CommentController@restore')->where('id', '[0-9]+');
    });

    // /api/user
    Route::group(['prefix' => 'user'], function() {
        Route::post('{username}/ban', 'UserController@ban');
    });

    // /api/video
    Route::group(['prefix' => 'video'], function() {
        Route::post('{id}/delete', 'VideoController@destroy')->where('id', '[0-9]+');
    });

    Route::post('upload', 'VideoController@store');
});

Route::get('{id}', 'VideoController@show')->where('id', '[0-9]+');
Route::get('{id}/fav', 'VideoController@favorite')->where('id', '[0-9]+');
Route::post('{id}', 'CommentController@store')->where('id', '[0-9]+');

Route::get('{shortname}', 'CategoryController@showVideo')->where('shortname', '[a-z][a-z0-9]+');
Route::get('{shortname}/{id}', 'CategoryController@showVideo')->where(['shortname' => '[a-z][a-z0-9]+', 'id' => '[0-9]+']);
