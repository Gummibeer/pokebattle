<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePokemonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pokemons', function (Blueprint $table) {
            $table->integer('id')->unsigned()->primary();
            $table->string('name');
            $table->integer('attack')->unsigned();
            $table->integer('defense')->unsigned();
            $table->integer('speed')->unsigned();
            $table->integer('health')->unsigned();
            $table->integer('experience')->unsigned();
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
        Schema::dropIfExists('pokemons');
    }
}
