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
    return view('welcome');
});

Route::post('auth/login', 'AuthController@login')->name('auth.login');
Route::post('auth/refresh-token', 'AuthController@refreshToken')->name('auth.refresh-token');
Route::post('auth/login/facebook', 'AuthController@loginFacebook')->name('auth.loginFacebook');
Route::get('user/active/{token}', 'UserController@active')->name('user.active');

Route::post('password/email', 'Auth\PasswordController@email');
Route::get('password/verify-token/{token}', 'Auth\PasswordController@verify');
Route::post('password/reset', 'Auth\PasswordController@reset');

Route::post('user', 'UserController@store')->name('user.store');
Route::get('search', 'UserController@search')->name('global.search');
Route::get('suggestion', 'SongController@suggestion')->name('global.suggestion');

//Route::group(['middleware' => ['jwt.auth']], function() {
Route::group(['middleware' => []], function () {
    // /user/
    Route::get('user/authenticated', 'UserController@authenticated')->name('user.authenticated')->middleware('jwt.auth');
    Route::resource('user', 'UserController', ['except' => ['create', 'store', 'edit']]);
    Route::post('user/change-password', 'UserController@changePassword')->name('user.change-password');
    Route::post('user/avatar', 'UserController@avatar')->name('user.avatar');

    // Album
    Route::resource('album', 'AlbumController', ['except' => ['create', 'edit', 'update']]);
    Route::post('album/{id}', 'AlbumController@update')->name('album.update');

    // Song
    Route::resource('song', 'SongController', ['except' => ['create', 'edit', 'update']]);
    Route::post('song/{id}', 'SongController@update');

    // Video
    Route::resource('video', 'VideoController', ['except' => ['create', 'edit']]);
    Route::post('video/upload', 'VideoController@upload')->name('video.upload');

    // Show
    Route::resource('show', 'ShowController', ['except' => ['create', 'edit']]);

    // News
    Route::get('news/listing', 'NewsController@listing')->name('news.listing');
    Route::get('news/detail/{id}', 'NewsController@detail')->name('news.detail');
    Route::resource('news', 'NewsController', ['except' => ['create', 'edit']]);
    Route::post('news/upload', 'NewsController@upload')->name('news.upload');

    // Photo
    Route::resource('photo', 'PhotoController', ['except' => ['create', 'edit']]);
    Route::post('photo/upload', 'PhotoController@upload')->name('photo.upload');

    // Advert
    Route::resource('advert', 'AdvertController', ['except' => ['create', 'edit']]);
    
    // Version
    Route::resource('version', 'VersionController', ['except' => []]);
    
    // Category
    Route::resource('category', 'CategoryController', ['except' => []]);

    // Post
    Route::get('post/', 'PostController@index');
    Route::get('post/{id}', 'PostController@show');
    Route::get('post/latest/{singerId}', 'PostController@latest');

    // Comment
    Route::get('post/{post_id}/comment', 'CommentController@index');
    Route::get('comment/{id}', 'CommentController@show');

    //TODO  /photo/

    // Static
    Route::get('about', 'StaticController@about')->name('static.about');

    // Website
    Route::get('website/{singer_id}/content/{type?}', 'WebsiteController@content');

});

//Require permission
Route::group(['middleware' => ['jwt.auth']], function () {

    // /post/
    Route::post('post/', 'PostController@store');
    Route::post('post/{id}', 'PostController@update');
    Route::delete('post/{id}', 'PostController@destroy');
    //Route::post('post/upload', 'PostController@upload');

    // /comment/
    Route::post('post/{post_id}/comment', 'CommentController@store');
    Route::put('comment/{id}', 'CommentController@update');
    Route::delete('comment/{id}', 'CommentController@update');

    // /post/like/
    Route::post('post/{post_id}/like', 'PostController@like');
    Route::post('post/{post_id}/unlike', 'PostController@unlike');

    // /payment/
    Route::post('payment/{singer_id}/charge', 'PaymentController@charge');
    Route::get('payment/{singer_id}/status', 'PaymentController@status');
    Route::post('payment/{singer_id}/subscribe', 'PaymentController@subscribe');

    // /website/
    Route::post('website/{singer_id}/setup', 'WebsiteController@setup');
    Route::put('website/{singer_id}/update', 'WebsiteController@update');
    Route::post('website/upload', 'WebsiteController@upload');

    // /settings/
    Route::get('setting/', 'SettingController@get');
    Route::post('setting/', 'SettingController@manage');

});


