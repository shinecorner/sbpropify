<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDitrictRelatedColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->renameColumn('district_id', 'quarter_id');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('district_id', 'quarter_id');
        });
        Schema::table('quarter_post', function (Blueprint $table) {
            $table->renameColumn('district_id', 'quarter_id');
        });
        Schema::table('quarter_property_manager', function (Blueprint $table) {
            $table->renameColumn('district_id', 'quarter_id');
        });
        Schema::table('quarter_service_provider', function (Blueprint $table) {
            $table->renameColumn('district_id', 'quarter_id');
        });
        Schema::table('quarters', function (Blueprint $table) {
            $table->renameColumn('district_format', 'quarter_format');
        });
        Schema::table('real_estates', function (Blueprint $table) {
            $table->renameColumn('district_enable', 'quarter_enable');
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
            $table->renameColumn('quarter_id', 'district_id');
        });
        Schema::table('buildings', function (Blueprint $table) {
            $table->renameColumn('quarter_id', 'district_id');
        });
        Schema::table('quarter_post', function (Blueprint $table) {
            $table->renameColumn('quarter_id', 'district_id');
        });
        Schema::table('quarter_property_manager', function (Blueprint $table) {
            $table->renameColumn('quarter_id', 'district_id');
        });
        Schema::table('quarter_service_provider', function (Blueprint $table) {
            $table->renameColumn('quarter_id', 'district_id');
        });
        Schema::table('quarters', function (Blueprint $table) {
            $table->renameColumn('quarter_format', 'district_format');
        });
        Schema::table('real_estates', function (Blueprint $table) {
            $table->renameColumn('quarter_enable', 'district_enable');
        });
    }
}
