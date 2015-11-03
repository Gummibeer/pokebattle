<?php

namespace App\Console;

use App\Console\Commands\RunPokemonFight;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        RunPokemonFight::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('pokemonfight:run')->everyMinute();
    }
}
