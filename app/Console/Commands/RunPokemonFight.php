<?php
namespace App\Console\Commands;

use App\Libs\PokemonFight;
use App\Pokemon;
use App\User;
use Illuminate\Console\Command;

class RunPokemonFight extends Command
{
    protected $signature = 'pokemonfight:run {defender? : The User-ID of the defending Trainer}';
    protected $description = 'Runs a PokemonFight between two Trainers.';

    public function handle()
    {
        $defenderID = $this->argument('defender');
        $defender = is_null($defenderID) ? User::player()->get()->random() : User::findOrFail($defenderID);
        $attacker = new User([
            'name' => '[BOT]',
            'bot' => true,
        ]);
        $attacker->pokemon = Pokemon::starter()->get()->random();
        $attacker->experience = getNeededExpByLevel(getCurLvl($defender) - floor(rand(1, 3)), $attacker);
        $fight = new PokemonFight($attacker, $defender);
        $fight->run();
    }
}
