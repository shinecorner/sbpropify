<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loc_countries', function (Blueprint $table) {
            $table->string('alpha_3')->after('code');
            $table->string('name_de');
            $table->string('name_fr');
            $table->string('name_it');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loc_countries', function (Blueprint $table) {
            $table->dropColumn('alpha_3', 'name_de', 'name_fr', 'name_it');
        });
    }
}
