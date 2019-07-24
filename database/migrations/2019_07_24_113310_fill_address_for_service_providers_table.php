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
            \App\Models\ServiceProvider::with('address')->get()->each(function ($tenant) {
                $tenant->country_id = $tenant->address->country_id ?? null;
                $tenant->state_id = $tenant->address->state_id ?? null;
                $tenant->city = $tenant->address->city ?? null;
                $tenant->street = $tenant->address->street ?? null;
                $tenant->street_nr = $tenant->address->street_nr ?? null;
                $tenant->zip = $tenant->address->zip ?? null;
                $tenant->save();
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
