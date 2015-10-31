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
        $weatherRatio = (array)config('weather.ratio');
        shuffle($weatherRatio);

        view()->share('weather', [
            'today' => \Cache::rememberForever(str_slug('weather ' . $today->toDateString()), function () use ($weatherRatio) {
                $type = array_get($weatherRatio, rand(0, count($weatherRatio) - 1), 'sun');
                return config('weather.' . $type);
            }),
            'tomorrow' => \Cache::rememberForever(str_slug('weather ' . $tomorrow->toDateString()), function () use ($weatherRatio) {
                $type = array_get($weatherRatio, rand(0, count($weatherRatio) - 1), 'sun');
                return config('weather.' . $type);
            }),
        ]);

        view()->share('moonPhase', [
            'today' => str_slug((new MoonPhase(Carbon::now()->timestamp))->phase_name()),
            'tomorrow' => str_slug((new MoonPhase(Carbon::tomorrow()->timestamp))->phase_name()),
        ]);

        view()->share('pokemonOfTheDay', \Cache::rememberForever(str_slug('pokemon ' . $today->toDateString()), function () use ($weatherRatio) {
            return Pokemon::find(array_rand(Pokemon::lists('id')->toArray()));
        }));
    }

    public function register()
    {
        //
    }
}
