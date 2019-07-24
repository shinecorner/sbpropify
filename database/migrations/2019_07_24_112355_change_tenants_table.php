<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->integer('country_id')->unsigned()->nullable()->after('unit_id');
            $table->integer('state_id')->unsigned()->nullable()->after('unit_id');
            $table->string('zip')->after('tenant_format');
            $table->string('street_nr')->after('tenant_format');
            $table->string('street')->after('tenant_format');
            $table->string('city')->after('tenant_format');
            $table->foreign('country_id')->references('id')->on('loc_countries');
            $table->foreign('state_id')->references('id')->on('loc_states');
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
            $table->dropForeign('tenants_country_id_foreign');
            $table->dropForeign('tenants_state_id_foreign');
            $table->dropColumn('country_id', 'state_id', 'city', 'street', 'street_nr', 'zip');
        });
    }
}
