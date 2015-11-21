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

    protected $trainers = [
        'Ethan',
        'Brendan',
        'Lucas',
        'Hilbert',
        'Nate',
        'Calem',
        'Kris',
        'May',
        'Leaf',
        'Dawn',
        'Lyra',
        'Hilda',
        'Rosa',
        'Serena',
        'Wes',
        'Michael',
        'Mark',
        'Mint',
        'Lunick',
        'Kellyn',
        'Ben',
        'Solana',
        'Kate',
        'Summer',
    ];

    public function handle()
    {
        $defenderID = $this->argument('defender');
        $defender = is_null($defenderID) ? User::player()->get()->random() : User::findOrFail($defenderID);

        $bot = new User([
            'name' => collect($this->trainers)->random() . ' [BOT]',
            'email' => str_random(64).'.'.time().'@bots.pokebattle.de',
            'bot' => true,
        ]);
        $bot->save();
        $bot->pokemons()->sync([
            Pokemon::starter()->get()->random()->id => [
                'active' => 1,
            ],
        ]);
        $experience = getNeededExpByLevel(getCurLvl($defender) - floor(rand(3, 15)), $bot);
        $bot->pokemons()->sync([
            $bot->pokemon->id => [
                'experience' => $experience,
            ],
        ], false);
        $fight = new PokemonFight($bot, $defender);
        $fight->run();
    }
}
