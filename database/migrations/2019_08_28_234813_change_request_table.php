<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::select('ALTER TABLE `service_request_categories` CHANGE `location` `location` TINYINT(4) NULL DEFAULT \'0\';');
        \Illuminate\Support\Facades\DB::select('ALTER TABLE `service_request_categories` CHANGE `room` `room` TINYINT(4) NULL DEFAULT \'0\';');
        \Illuminate\Support\Facades\DB::table('service_request_categories')->whereNull('room')->update(['room' => 0]);
        \Illuminate\Support\Facades\DB::table('service_request_categories')->whereNull('location')->update(['location' => 0]);
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
