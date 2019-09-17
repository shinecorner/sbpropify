<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrimaryColorLighterInRealEstateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('real_estates', function (Blueprint $table) {
            $table->string('primary_color_lighter')->after('primary_color')->default('#c55a9059');
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
            $table->dropColumn('primary_color_lighter');
        });
    }
}
