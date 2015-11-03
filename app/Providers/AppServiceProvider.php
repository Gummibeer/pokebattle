<?php

namespace App\Providers;

use App\Pokemon;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Solaris\MoonPhase;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        view()->share('weather', [
            'today' => getWeatherByDate($today),
            'tomorrow' => getWeatherByDate($tomorrow),
        ]);

        view()->share('moonPhase', [
            'today' => str_slug((new MoonPhase(Carbon::now()->timestamp))->phase_name()),
            'tomorrow' => str_slug((new MoonPhase(Carbon::tomorrow()->timestamp))->phase_name()),
        ]);

        view()->share('pokemonOfTheDay', \Cache::rememberForever(str_slug('pokemon ' . $today->toDateString()), function () {
            return Pokemon::find(array_rand(Pokemon::lists('id')->toArray()));
        }));
    }

    public function register()
    {
        //
    }
}
