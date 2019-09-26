<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNationalityInTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('nation')->after('tenant_format')->nullable();
            $table->integer('country_id')->unsigned()->nullable()->after('unit_id');
            $table->foreign('country_id')->references('id')->on('loc_countries');
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
            $table->dropColumn('nation', 'country_id');
        });
    }
}
