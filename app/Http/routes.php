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

// ALIASES
Route::get('/', function () {
    return redirect()->to('de/app/dashboard');
});
Route::get('auth', function () {
    return redirect()->to('de/auth/login');
});
Route::get('app', function () {
    return redirect()->to('de/app/dashboard');
});
Route::get('home', function () {
    return redirect()->to('de/app/dashboard');
});

Route::group(['prefix' => '{locale?}', 'before' => 'localization'], function () {
    // ALIASES
    Route::get('/', function () {
        return redirect()->to(Route::input('locale') . '/app/dashboard');
    });
    Route::get('auth', function () {
        return redirect()->to(Route::input('locale') . '/auth/login');
    });
    Route::get('app', function () {
        return redirect()->to(Route::input('locale') . '/app/dashboard');
    });
    Route::get('home', function () {
        return redirect()->to(Route::input('locale') . '/app/dashboard');
    });

    Route::controller('auth', 'Auth\AuthController');

    Route::group(['prefix' => 'app', 'namespace' => 'App', 'middleware' => 'auth'], function () {
        Route::controller('dashboard', 'DashboardController');
        Route::controller('pokedex', 'PokedexController');
        Route::controller('fight', 'FightController');
        Route::controller('pokepc', 'PokepcController');

        Route::controller('notification', 'NotificationController');
    });
});

Route::filter('localization', function () {
    $locale = Route::input('locale');
    if (!in_array($locale, config('app.supported_locales'))) $locale = config('app.locale');
    App::setLocale($locale);
});