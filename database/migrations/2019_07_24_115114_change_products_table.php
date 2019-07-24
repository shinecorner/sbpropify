<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('zip')->after('visibility');
            $table->string('street_nr')->after('visibility');
            $table->string('street')->after('visibility');
            $table->string('city')->after('visibility');
            $table->integer('country_id')->unsigned()->nullable()->after('user_id');
            $table->integer('state_id')->unsigned()->nullable()->after('user_id');
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

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_country_id_foreign');
            $table->dropForeign('products_state_id_foreign');
            $table->dropColumn('country_id', 'state_id', 'city', 'street', 'street_nr', 'zip');
        });
    }
}
