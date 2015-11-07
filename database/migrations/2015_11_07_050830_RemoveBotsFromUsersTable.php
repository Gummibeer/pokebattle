<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveBotsFromUsersTable extends Migration
{
    public function up()
    {
        $bots = \App\User::bot()->get();
        foreach($bots as $bot) {
            $bot->pokemons()->sync([]);
            $bot->battlemessages()->delete();
            \App\Battlehistory::user($bot->id)->delete();
            $bot->delete();
        }

        Schema::table('battlehistories', function (Blueprint $table) {
            $table->integer('attacker_user_id')->unsigned()->nullable()->change();
            $table->integer('attacker_pokemon_id')->unsigned()->nullable()->change();
            $table->integer('defender_user_id')->unsigned()->nullable()->change();
            $table->integer('defender_pokemon_id')->unsigned()->nullable()->change();
        });
    }

    public function down()
    {
    }
}
