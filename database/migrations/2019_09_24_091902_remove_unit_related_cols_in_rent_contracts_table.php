<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnitRelatedColsInRentContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenant_rent_contracts', function (Blueprint $table) {
            $table->dropColumn('operating_cost', 'gross_rent', 'net_rent');
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
            $table->integer('net_rent')->nullable()->default(0);
            $table->integer('operating_cost')->nullable()->default(0);
            $table->integer('gross_rent')->nullable()->default(0);
        });
    }
}
