<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenamePostIdToPinboradIdInPostView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pinboard_view', function (Blueprint $table) {
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
        Schema::table('pinboard_view', function (Blueprint $table) {
            $table->renameColumn('pinboard_id', 'post_id');
        });
    }
}
