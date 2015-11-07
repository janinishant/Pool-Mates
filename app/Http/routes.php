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

// goto home
Route::get('/', ['as' => 'landing', 'uses' => 'HomeController@index']);

//provider can be any, twitter, facebook, etc
Route::get('login/{provider?}', 'AuthController@login');

Route::get('/logout', 'AuthController@logout');

Route::group(array('prefix' => 'api/v1'), function()
{
    Route::resource('request', 'RequestController');
    Route::resource('request_match', 'RequestMatchController');
});

Route::get('/profile', 'ProfileController@userinfo');
Route::get('/profile/edit', 'ProfileController@edituserinfo');