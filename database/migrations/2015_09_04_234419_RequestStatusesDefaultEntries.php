<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RequestStatusesDefaultEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_statuses', function (Blueprint $table) {
            $sql = "INSERT INTO `request_statuses` (`name`) VALUES ('open'),('expired'), ('matched'), ('closed');";
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
        Schema::table('request_statuses', function (Blueprint $table) {
            $sql = "DELETE FROM `request_statuses` WHERE name IN ('open','expired', 'matched', 'closed');";
            DB::connection()->getPdo()->exec($sql);
        });
    }
}
