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

Route::group(['prefix' => 'app', 'namespace' => 'App', 'middleware' => 'auth'], function () {
    Route::controller('dashboard', 'DashboardController');
    Route::controller('pokedex', 'PokedexController');

    Route::controller('notification', 'NotificationController');
});

// ALIASES
Route::get('/', function() { return redirect()->to('app/dashboard'); });
Route::get('auth', function() { return redirect()->to('auth/login'); });
Route::get('app', function() { return redirect()->to('app/dashboard'); });
Route::get('home', function() { return redirect()->to('app/dashboard'); });
