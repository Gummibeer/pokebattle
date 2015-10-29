<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->text('message');
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
