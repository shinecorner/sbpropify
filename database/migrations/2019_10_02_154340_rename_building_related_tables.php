<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameBuildingRelatedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('building_pinboard', 'listing_pinboard');
        Schema::rename('building_service_provider', 'listing_service_provider');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('listing_assignees', 'building_assignees');
        Schema::rename('listing_pinboard', 'building_pinboard');
        Schema::rename('listing_service_provider', 'building_service_provider');
    }
}
