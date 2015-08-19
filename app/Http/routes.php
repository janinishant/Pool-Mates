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


//testing GDM API
Route::get('test', 'HomeController@testing');