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
        Schema::table('quarters_post', function (Blueprint $table) {
            $table->renameColumn('district_id', 'quarter_id');
        });
        Schema::table('quarters_property_manager', function (Blueprint $table) {
            $table->renameColumn('district_id', 'quarter_id');
        });
        Schema::table('quarters_service_provider', function (Blueprint $table) {
            $table->renameColumn('district_id', 'quarter_id');
        });
        Schema::table('quarters', function (Blueprint $table) {
            $table->renameColumn('district_format', 'quarter_format');
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
            $table->renameColumn('quarter_id', 'district_id');
        });
        Schema::table('quarters_post', function (Blueprint $table) {
            $table->renameColumn('quarter_id', 'district_id');
        });
        Schema::table('quarters_property_manager', function (Blueprint $table) {
            $table->renameColumn('quarter_id', 'district_id');
        });
        Schema::table('quarters_service_provider', function (Blueprint $table) {
            $table->renameColumn('quarter_id', 'district_id');
        });
        Schema::table('quarters', function (Blueprint $table) {
            $table->renameColumn('quarter_format', 'district_format');
        });
    }
}
