<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBattlemessagesTable extends Migration
{
    public function up()
    {
        Schema::create('battlemessages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('message_key');
            $table->text('data');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('battlemessages');
    }
}
