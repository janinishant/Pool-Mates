<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_address', function (Blueprint $table) {
            $sql = "CREATE TABLE `entity_address` (`id` INT(11) auto_increment primary key,
                    `full_address_text` VARCHAR(100) NOT NULL,
                    `street_name` VARCHAR(50) NOT NULL,
                    `route` VARCHAR (255) NOT NULL,
                    `neighborhood` VARCHAR (255) NOT NULL,
                    `locality` VARCHAR (255) NOT NULL,
                    `administrative_area_level_2` VARCHAR (255) NOT NULL,
                    `administrative_area_level_1` VARCHAR (255) NOT NULL,
                    `country` VARCHAR (255) NOT NULL,
                    `postal_zip` VARCHAR (20) NOT NULL,
                    `lat` POINT NOT NULL,
                    `lng` POINT NOT NULL)";
            DB::connection()->getPdo()->exec($sql);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
