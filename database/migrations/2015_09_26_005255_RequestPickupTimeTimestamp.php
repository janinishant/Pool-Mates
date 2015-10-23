<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RequestPickupTimeTimestamp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::connection()->getPdo()->exec( "ALTER TABLE `request_pickup_times` CHANGE `time_id` `pickup_timestamp` TIMESTAMP NOT NULL" );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::connection()->getPdo()->exec( "ALTER TABLE `request_pickup_times` `pickup_timestamp` `time_id` INT (11) NOT NULL" );
    }
}
