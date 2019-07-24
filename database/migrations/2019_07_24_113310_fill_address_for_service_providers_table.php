<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FillAddressForServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (class_exists("App\Models\Address")) {
            \App\Models\ServiceProvider::with('address')->get()->each(function ($serviceProvider) {
                $serviceProvider->country_id = $serviceProvider->address->country_id ?? null;
                $serviceProvider->state_id = $serviceProvider->address->state_id ?? null;
                $serviceProvider->city = $serviceProvider->address->city ?? null;
                $serviceProvider->street = $serviceProvider->address->street ?? null;
                $serviceProvider->street_nr = $serviceProvider->address->street_nr ?? null;
                $serviceProvider->zip = $serviceProvider->address->zip ?? null;
                $serviceProvider->save();
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
