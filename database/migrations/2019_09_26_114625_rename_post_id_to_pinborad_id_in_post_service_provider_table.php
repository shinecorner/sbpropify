<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenamePostIdToPinboradIdInPostServiceProviderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_service_provider', function (Blueprint $table) {
            $table->renameColumn('post_id', 'pinboard_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_service_provider', function (Blueprint $table) {
            $table->renameColumn('pinboard_id', 'post_id');
        });
    }
}
