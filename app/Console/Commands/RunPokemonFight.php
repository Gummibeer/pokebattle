<?php
namespace App\Console\Commands;

use App\Libs\PokemonFight;
use App\User;
use Illuminate\Console\Command;

class RunPokemonFight extends Command
{
    protected $signature = 'pokemonfight:run {attacker? : The User-ID of the attacking Trainer} {defender? : The User-ID of the defending Trainer}';
    protected $description = 'Runs a PokemonFight between two Trainers.';

    public function handle()
    {
        $attackerID = $this->argument('attacker');
        $defenderID = $this->argument('defender');
        $attacker = is_null($attackerID) ? User::player()->get()->random() : User::findOrFail($attackerID);
        $defender = is_null($defenderID) ? User::where('id', '<>', $attacker->id)->get()->random() : User::findOrFail($defenderID);
        $fight = new PokemonFight($attacker, $defender);
        $fight->run();
    }
}
