<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FillNewColumnsInBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (class_exists("App\Models\Address")) {
            \App\Models\Building::with('address')->get()->each(function ($building) {
                $building->country_id = $building->address->country_id ?? null;
                $building->state_id = $building->address->state_id ?? null;
                $building->city = $building->address->city ?? null;
                $building->street = $building->address->street ?? null;
                $building->street_nr = $building->address->street_nr ?? null;
                $building->zip = $building->address->zip ?? null;
                $building->save();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buildings', function (Blueprint $table) {
            //
        });
    }
}
