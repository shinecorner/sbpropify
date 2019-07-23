<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->integer('country_id')->unsigned()->nullable()->after('district_id');
            $table->integer('state_id')->unsigned()->nullable()->after('district_id');
            $table->string('zip')->after('longitude');
            $table->string('street_nr')->after('longitude');
            $table->string('street')->after('longitude');
            $table->string('city')->after('longitude');
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
        Schema::table('buildings', function (Blueprint $table) {
            $table->dropForeign('buildings_country_id_foreign');
            $table->dropForeign('buildings_state_id_foreign');
            $table->dropColumn('country_id', 'state_id', 'city', 'street', 'street_nr', 'zip');
        });
    }
}
