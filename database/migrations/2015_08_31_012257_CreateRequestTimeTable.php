<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasTable('request_pickup_times')) {
            Schema::create('request_pickup_times', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('request_id');
                $table->integer('time_id', false, true)->nullable();
                $table->foreign('request_id')->references('id')->on('requests');
                $table->foreign('time_id')->references('id')->on('pickup_times');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('requests');
    }
}
