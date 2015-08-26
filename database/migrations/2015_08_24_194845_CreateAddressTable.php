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
                    ``
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
