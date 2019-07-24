<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRealEstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('real_estates', function (Blueprint $table) {
            $table->string('zip')->after('address_id');
            $table->string('street_nr')->after('address_id');
            $table->string('street')->after('address_id');
            $table->string('city')->after('address_id');
            $table->integer('country_id')->unsigned()->nullable()->after('address_id');
            $table->integer('state_id')->unsigned()->nullable()->after('address_id');
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
        Schema::table('real_estates', function (Blueprint $table) {
            $table->dropForeign('real_estates_country_id_foreign');
            $table->dropForeign('real_estates_state_id_foreign');
            $table->dropColumn('country_id', 'state_id', 'city', 'street', 'street_nr', 'zip');
        });
    }
}
