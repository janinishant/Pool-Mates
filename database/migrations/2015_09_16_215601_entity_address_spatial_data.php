<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EntityAddressSpatialData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('entity_address', function (Blueprint $table) {

            $table->dropColumn('lat');
            $table->dropColumn('lng');
        });
        DB::connection()->getPdo()->exec( "ALTER TABLE `entity_address` ADD COLUMN `geo_location` POINT NOT NULL" );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('entity_address', function (Blueprint $table) {
            $table->dropColumn('geo_location');
        });
        DB::connection()->getPdo()->exec( "ALTER TABLE `entity_address` ADD COLUMN `lat` POINT NOT NULL" );
        DB::connection()->getPdo()->exec( "ALTER TABLE `entity_address` ADD COLUMN `lng` POINT NOT NULL" );
    }
}
