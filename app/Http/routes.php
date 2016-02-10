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
    $id = App\Models\Video::count() - 1;
    $id = rand(0, $id);
    $video = App\Models\Video::skip($id)->first();
    return redirect($video->id);
}]);


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
Route::get('about', function() { return view('about'); });
Route::get('irc', function() { return view('irc'); });
Route::get('impressum', function() { return view('impressum'); });
Route::get('donate', function() { return view('donate'); });
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

Route::group(['prefix' => 'api'], function() {
    Route::get('messages', 'MessageController@index');
});

Route::get('comment/{id}/delete', 'VideoController@destroyComment')->where('id', '[0-9]+');
Route::get('comment/{id}/restore', 'VideoController@restoreComment')->where('id', '[0-9]+');

Route::get('{id}', 'VideoController@show')->where('id', '[0-9]+');
Route::get('{id}/fav', 'VideoController@favorite')->where('id', '[0-9]+');
Route::get('{id}/delete', 'VideoController@destroy')->where('id', '[0-9]+');
Route::post('{id}', 'VideoController@storeComment')->where('id', '[0-9]+');

Route::get('{shortname}', 'CategoryController@showVideo')->where('shortname', '[a-z][a-z0-9]+');
Route::get('{shortname}/{id}', 'CategoryController@showVideo')->where(['shortname' => '[a-z][a-z0-9]+', 'id' => '[0-9]+']);
