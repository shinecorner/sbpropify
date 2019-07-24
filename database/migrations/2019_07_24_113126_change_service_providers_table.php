<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_providers', function (Blueprint $table) {
            $table->integer('country_id')->unsigned()->nullable()->after('address_id');
            $table->integer('state_id')->unsigned()->nullable()->after('address_id');
            $table->string('zip')->after('service_provider_format');
            $table->string('street_nr')->after('service_provider_format');
            $table->string('street')->after('service_provider_format');
            $table->string('city')->after('service_provider_format');
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
        Schema::table('service_providers', function (Blueprint $table) {
            $table->dropForeign('service_providers_country_id_foreign');
            $table->dropForeign('service_providers_state_id_foreign');
            $table->dropColumn('country_id', 'state_id', 'city', 'street', 'street_nr', 'zip');
        });
    }
}
