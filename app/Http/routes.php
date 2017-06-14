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
Route::post('auth/manager', 'AuthController@manager')->name('auth.manager');
Route::post('auth/refresh-token', 'AuthController@refreshToken')->name('auth.refresh-token');
Route::post('auth/login/facebook', 'AuthController@loginFacebook')->name('auth.loginFacebook');
Route::get('user/active/{token}', 'UserController@active')->name('user.active');

Route::post('password/email', 'Auth\PasswordController@email');
Route::get('password/verify-token/{token}', 'Auth\PasswordController@verify');
Route::post('password/reset', 'Auth\PasswordController@reset');

Route::post('user', 'UserController@store')->name('user.store');
Route::get('search', 'UserController@search')->name('global.search');
Route::get('suggestion', 'SongController@suggestion')->name('global.suggestion');

// /apps/
Route::resource('apps', 'AppController');
Route::post('apps/{id}', 'AppController@update');

// /device/
Route::resource('device', 'DeviceController', ['except' => ['create', 'edit']]);

// /notification/
Route::resource('notification', 'NotificationController', ['except' => ['create', 'edit']]);

// /live/
Route::get('live/', 'LiveController@getCurrentLive');

//Route::group(['middleware' => ['jwt.auth']], function() {
Route::group(['middleware' => []], function () {
    // Auth
    Route::get('auth/authenticated', 'AuthController@authenticated')->name('auth.authenticated')->middleware('jwt.auth');
    Route::get('auth/type', 'AuthController@type')->name('auth.type');
    Route::post('auth/change-password', 'AuthController@changePassword')->name('auth.change-password');
    Route::post('auth/change-info', 'AuthController@changeInfo')->name('auth.change-info');
    Route::post('auth/avatar', 'AuthController@avatar')->name('auth.avatar');

    // /user/
    Route::resource('user', 'UserController', ['except' => ['create', 'store', 'edit']]);

    // /master/
    Route::resource('master', 'MasterController');

    // Album
    Route::resource('album', 'AlbumController', ['except' => ['create', 'edit', 'update']]);
    Route::post('album/{id}', 'AlbumController@update')->name('album.update');

    // Song
    Route::post('song/delete', 'SongController@delete');
    Route::post('song/feature', 'SongController@feature');
    Route::post('song/set-public', 'SongController@setPublic');
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
    Route::get('version/listing', 'VersionController@listing')->name('version.listing');
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

    // /live config/
    Route::get('live_config/{content_id}', 'LiveConfigurationController@show');
    Route::post('live_config/', 'LiveConfigurationController@store');
    Route::put('live_config/{id}', 'LiveConfigurationController@update');

    // /live/
    Route::post('live/', 'LiveController@store');
    Route::put('live/', 'LiveController@update');
    Route::post('live/finish', 'LiveController@finish');

});


