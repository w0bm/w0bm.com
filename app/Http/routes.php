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
Route::get('api/messages', 'MessageController@index');
Route::post('api/messages/read', 'MessageController@read');
Route::get('api/messages/readall', 'MessageController@readall');
Route::get('user/{username}', 'UserController@show');
Route::get('user/{username}/favs', 'UserController@show_favs');
Route::get('logout', 'UserController@logout');
Route::post('login', 'UserController@login');
Route::get('register', 'UserController@create');
Route::post('register', 'UserController@store');
Route::get('activate/{token}', 'UserController@activate');
Route::get('songindex', 'VideoController@index');
Route::post('songindex/{id}', 'VideoController@update');
Route::get('upload', 'VideoController@create');
Route::post('upload', 'VideoController@store');
Route::get('categories', 'CategoryController@index');
Route::get('webm', function() { return view('webm'); });
Route::get('about', function() { return view('about'); });
Route::get('irc', function() { return view('irc'); });
Route::get('contact', function() { return view('contact'); });
Route::get('privacy', function() { return view('privacy'); });
Route::get('help', function() { return view('help'); });
Route::get('donate', function() { return view('donate'); });
Route::get('login', function() { return view('login'); });
Route::get('togglebackground', function() {
    $request = request();
    $user = auth()->check() ? auth()->user() : null;

    if(is_null($user)) {
        Session::put('background', !Session::get('background', true));
    } else {
        $user->background = !$user->background;
        Session::put('background', $user->background);
        $user->save();
    }

    if($request->ajax())
        return json_encode(true);

    return redirect()->back()->with('success, Background toggled');
});

Route::post('filter', 'UserController@filter');

Route::group(['prefix' => 'api'], function() {
    Route::get('messages', 'MessageController@index');
});

Route::get('comment/{id}/edit', 'VideoController@editComment')->where('id', '[0-9]+');
Route::get('comment/{id}/delete', 'VideoController@destroyComment')->where('id', '[0-9]+');
Route::get('comment/{id}/restore', 'VideoController@restoreComment')->where('id', '[0-9]+');

Route::get('{id}', 'VideoController@show')->where('id', '[0-9]+');
Route::get('{id}/fav', 'VideoController@favorite')->where('id', '[0-9]+');
Route::get('{id}/delete', 'VideoController@destroy')->where('id', '[0-9]+');
Route::post('{id}/tag', 'VideoController@tag')->where('id', '[0-9]+');
Route::post('{id}', 'VideoController@storeComment')->where('id', '[0-9]+');

Route::get('{shortname}', 'CategoryController@showVideo')->where('shortname', '[a-z][a-z0-9]+');
Route::get('{shortname}/{id}', 'CategoryController@showVideo')->where(['shortname' => '[a-z][a-z0-9]+', 'id' => '[0-9]+']);
