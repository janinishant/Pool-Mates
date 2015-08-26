<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('requests', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('requester_id');
            $table->string('source_address_id')->nullable();
            $table->string('destination_address_id')->nullable();
            $table->string('request_status');
            $table->timestamps();
            $table->foreign('requester_id')->references('id')->on('users');
            $table->foreign('request_status')->references('id')->on('request_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('requests');
    }
}
