<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultRentContractIdInTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->integer('default_rent_contract_id')->unsigned()->after('user_id')->nullable();
            $table->foreign('default_rent_contract_id')->references('id')->on('tenant_rent_contracts')->onUpdate('RESTRICT')->onDelete('RESTRICT');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropForeign('tenants_default_rent_contract_id_foreign');
            $table->dropColumn('default_rent_contract_id');
        });
    }
}
