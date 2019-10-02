<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameBuildingIdToListingIdInBuildingAssigneesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('building_assignees', function (Blueprint $table) {
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
        Schema::table('building_assignees', function (Blueprint $table) {
            $table->renameColumn('listing_id', 'building_id');
        });
    }
}
