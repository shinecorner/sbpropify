<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRentRelatedColsInRentContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenant_rent_contracts', function (Blueprint $table) {
            $table->decimal('monthly_rent_net')->nullable()->default(0.0)->after('parking_price');
            $table->decimal('monthly_rent_gross')->nullable()->default(0.0)->after('monthly_rent_net');
            $table->integer('monthly_maintenance')->nullable()->default(0.0)->after('monthly_rent_gross');
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
            $table->dropColumn('monthly_rent_net', 'monthly_rent_gross', 'monthly_maintenance');
        });
    }
}
