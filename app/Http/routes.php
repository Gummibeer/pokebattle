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

Route::controller('auth', 'Auth\AuthController');

Route::group(['prefix' => 'app', 'namespace' => 'App', 'middleware' => 'auth'], function() {
    Route::get('dashboard', 'DashboardController@getIndex');
});

// ALIASES
Route::get('auth', function () { return redirect('auth/login'); });
Route::get('/', function () { return redirect('app/dashboard'); });
Route::get('home', function () { return redirect('app/dashboard'); });
Route::get('app', function () { return redirect('app/dashboard'); });
