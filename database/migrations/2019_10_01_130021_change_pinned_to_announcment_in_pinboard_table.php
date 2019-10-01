<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePinnedToAnnouncmentInPinboardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pinboard', function (Blueprint $table) {
            $table->renameColumn('pinned', 'announcement');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pinboard', function (Blueprint $table) {
            $table->renameColumn('announcement', 'pinned');

        });
    }
}
