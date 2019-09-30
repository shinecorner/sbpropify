<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveParkingPriceInTenantRentContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenant_rent_contracts', function (Blueprint $table) {
            $table->dropColumn('parking_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenant_rent_contracts', function (Blueprint $table) {
            $table->integer('parking_price')->nullable()->default(0)->after('gross_rent');
        });
    }
}
