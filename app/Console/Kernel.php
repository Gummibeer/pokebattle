<?php

namespace App\Console;

use App\Console\Commands\LoadMoves;
use App\Console\Commands\LoadPokemons;
use App\Console\Commands\LoadTypes;
use App\Console\Commands\RunPokemonFight;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        RunPokemonFight::class,
        LoadMoves::class,
        LoadTypes::class,
        LoadPokemons::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('pokemonfight:run')->everyMinute();
    }
}
