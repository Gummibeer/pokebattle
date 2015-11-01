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
        $pokemonIds = \App\Pokemon::lists('id')->toArray();
        foreach($this->trainers as $trainer) {
            $bot = \App\User::create([
                'name' => $trainer.' [BOT]',
                'email' => strtolower($trainer).'@pokebattle.de',
                'bot' => true,
            ]);
            $bot->pokemons()->attach(array_rand($pokemonIds), ['active' => true]);
        }
    }

    public function down()
    {
    }
}
