<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameStreetNrInAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loc_addresses', function (Blueprint $table) {
            $table->renameColumn('street_nr', 'house_num');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loc_addresses', function (Blueprint $table) {
            $table->renameColumn('house_num', 'street_nr');
        });
    }
}
