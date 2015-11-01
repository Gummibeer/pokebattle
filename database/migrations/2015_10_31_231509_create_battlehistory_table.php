<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBattlehistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('battlehistory', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attacker_user_id')->unsigned();
            $table->foreign('attacker_user_id')->references('id')->on('users');
            $table->integer('attacker_pokemon_id')->unsigned();
            $table->foreign('attacker_pokemon_id')->references('id')->on('pokemons');
            $table->integer('defender_user_id')->unsigned();
            $table->foreign('defender_user_id')->references('id')->on('users');
            $table->integer('defender_pokemon_id')->unsigned();
            $table->foreign('defender_pokemon_id')->references('id')->on('pokemons');
            $table->boolean('attacker_win');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('battlehistory');
    }
}
