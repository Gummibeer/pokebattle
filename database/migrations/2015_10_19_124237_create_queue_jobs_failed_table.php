<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueueJobsFailedTable extends Migration
{
    public function up()
    {
        Schema::create('queue_jobs_failed', function (Blueprint $table) {
            $table->increments('id');
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->timestamp('failed_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('queue_jobs_failed');
    }
}
