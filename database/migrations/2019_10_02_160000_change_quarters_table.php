<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeQuartersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quarters', function (Blueprint $table) {
            $table->renameColumn('count_of_buildings', 'count_of_listings');
        });
        Schema::table('units', function (Blueprint $table) {
            $table->renameColumn('building_id', 'listing_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quarters', function (Blueprint $table) {
            $table->renameColumn('count_of_listings', 'count_of_buildings');
        });
        Schema::table('units', function (Blueprint $table) {
            $table->renameColumn('listing_id', 'building_id');
        });
    }
}
