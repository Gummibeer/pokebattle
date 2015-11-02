<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBotUsers extends Migration
{
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

    public function up()
    {
        $pokemonIds = \App\Pokemon::starter()->lists('id');
        foreach($this->trainers as $trainer) {
            $bot = \App\User::create([
                'name' => $trainer.' [BOT]',
                'email' => strtolower($trainer).'.bot@pokebattle.de',
                'bot' => true,
            ]);
            $bot->pokemons()->attach($pokemonIds->random(), ['active' => true]);
        }
    }

    public function down()
    {
    }
}
