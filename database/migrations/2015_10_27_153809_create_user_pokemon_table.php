<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPokemonTable extends Migration
{
    public function up()
    {
        Schema::create('user_pokemon', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('pokemon_id')->unsigned();
            $table->foreign('pokemon_id')->references('id')->on('pokemons');
            $table->integer('experience')->unsigned();
            $table->boolean('active');
            $table->unique(['user_id', 'pokemon_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_pokemon');
    }
}
