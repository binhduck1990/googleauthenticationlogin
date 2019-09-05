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
Route::namespace('Social')->group(function () {
    Route::get('/login','SocicalAuthController@login')->name('login');
    Route::get('/logout','SocicalAuthController@logout');
    Route::get('/auth/{provider}', 'SocicalAuthController@redirectToProvider');
    Route::get('/auth/{provider}/callback', 'SocicalAuthController@handleProviderCallback');
    Route::group(['middleware' => 'auth'], function() {
        Route::get('/profile','SocicalAuthController@profile');
        Route::post('/profile','SocicalAuthController@updateProfile');
    });

});