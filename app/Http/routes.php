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
    // Dummy query to calculate rows
    $video = \App\Models\Video::getRandom()->first();

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
Route::get('index', 'VideoController@index');
Route::post('index/{id}', 'VideoController@update');
Route::get('upload', 'VideoController@create');
Route::get('categories', 'CategoryController@index');
Route::get('webm', function() { return view('webm'); });
Route::get('about', function() { return view('about'); });
Route::get('irc', function() { return view('irc'); });
Route::get('rules', function() { return view('rules'); });
Route::get('contact', function() { return view('contact'); });
Route::get('privacy', function() { return view('privacy'); });
#Route::get('help', function() { return view('help'); });
#Route::get('announcement', function() { return view('announcement'); });
#Route::get('map', function() { return view('map'); });
#Route::get('donate', function() {
#    return view('donate', [
#        'donations' => \App\Models\Donation::orderBy('timestamp', 'DESC')->get()
#    ]);
#});
Route::get('transparency', function() { return view('transparency'); });
Route::get('login', function() { return view('login'); });
Route::get('advertise', function() { return view('advertise'); });
#Route::get('counter-strike', function() { return view('counter-strike'); });

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
        Route::get('random', function() {
            return \App\Models\Video::getRandom()->with(['category', 'user' => function($query) {
                $query->addSelect('username', 'id');
            }])->first();
        });
        Route::get('{id}', function($id) {
            $res = \App\Models\Video::with(['category', 'user' => function($query) {
                $query->addSelect('username', 'id');
            }])->find($id);
            if(!$res) {
                return response(['message' => 'Video not found'], 404);
            }
            return $res;
        })->where('id', '[0-9]+'); 
        Route::post('{id}/delete', 'VideoController@destroy')->where('id', '[0-9]+');
        Route::post('{id}/tag', 'VideoController@tag')->where('id', '[0-9]+');
        Route::post('{id}/untag', 'VideoController@untag')->where('id', '[0-9]+');
        Route::post('upload', 'VideoController@store')->middleware('auth.basic');
    });

    Route::post('upload', 'VideoController@store');
});

Route::get('{id}', 'VideoController@show')->where('id', '[0-9]+');
Route::get('{id}/fav', 'VideoController@favorite')->where('id', '[0-9]+');
Route::post('{id}', 'CommentController@store')->where('id', '[0-9]+');

Route::get('{shortname}', 'CategoryController@showVideo')->where('shortname', '[a-z][a-z0-9]+');
Route::get('{shortname}/{id}', 'CategoryController@showVideo')->where(['shortname' => '[a-z][a-z0-9]+', 'id' => '[0-9]+']);
