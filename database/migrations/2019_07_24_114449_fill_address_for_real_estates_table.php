<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FillAddressForRealEstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (class_exists("App\Models\Address")) {
            \App\Models\RealEstate::with('address')->get()->each(function ($realEstate) {
                $realEstate->country_id = $realEstate->address->country_id ?? null;
                $realEstate->state_id = $realEstate->address->state_id ?? null;
                $realEstate->city = $realEstate->address->city ?? null;
                $realEstate->street = $realEstate->address->street ?? null;
                $realEstate->street_nr = $realEstate->address->street_nr ?? null;
                $realEstate->zip = $realEstate->address->zip ?? null;
                $realEstate->save();
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
        //
    }
}
