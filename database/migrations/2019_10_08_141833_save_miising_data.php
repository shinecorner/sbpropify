<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SaveMiisingData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Tenant::whereNull('nation')->get()->each(function ($tenant) {
            $tenant->nation =  \App\Models\Country::inRandomOrder()->first()->id;
            $tenant->save();
        });
        \App\Models\Building::where('contact_enable', 0)->get()->each(function ($building) {
            $building->contact_enable =  array_rand(\App\Models\Building::BuildingContactEnables);
            $building->save();
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
