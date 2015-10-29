<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_relations', function (Blueprint $table) {
            $table->integer('cause_type_id')->unsigned();
            $table->foreign('cause_type_id')->references('id')->on('types');
            $table->integer('aim_type_id')->unsigned();
            $table->foreign('aim_type_id')->references('id')->on('types');
            $table->integer('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_relations');
    }
}
