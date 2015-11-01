<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->integer('experience')->unsigned();
            $table->integer('wins')->unsigned();
            $table->integer('looses')->unsigned();
            $table->integer('kills')->unsigned();
            $table->integer('deaths')->unsigned();
            $table->rememberToken();
            $table->boolean('bot')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
