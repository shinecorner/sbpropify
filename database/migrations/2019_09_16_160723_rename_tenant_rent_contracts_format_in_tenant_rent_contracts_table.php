<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTenantRentContractsFormatInTenantRentContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenant_rent_contracts', function (Blueprint $table) {
            $table->renameColumn('tenant_rent_contract_format', 'rent_contract_format');
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
            $table->renameColumn('rent_contract_format', 'tenant_rent_contract_format');
        });
    }
}
