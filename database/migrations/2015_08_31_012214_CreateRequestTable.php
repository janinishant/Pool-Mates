<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasTable('requests')) {
            Schema::create('requests', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('requester_id',false,true);
                $table->integer('source_address_id');
                $table->integer('destination_address_id');
                $table->integer('request_status_id', false, true);
                $table->timestamps();
                $table->foreign('requester_id')->references('id')->on('users');
                $table->foreign('source_address_id')->references('id')->on('entity_address');
                $table->foreign('destination_address_id')->references('id')->on('entity_address');
                $table->foreign('request_status_id')->references('id')->on('request_statuses');
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
        Schema::drop('requests');
    }
}
