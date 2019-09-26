<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveRentData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tenants = \App\Models\Tenant::whereNotNull('rent_start')->orWhereNotNull('building_id')->get();
        $tenants->each(function ($tenant) {
            \App\Models\RentContract::create([
                'tenant_id' => $tenant->id,
                'building_id' => $tenant->building_id,
                'unit_id' => $tenant->unit_id,
                'start_date' => $tenant->rent_start ?? now(),
                'end_date' => $tenant->rent_end
            ]);
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
