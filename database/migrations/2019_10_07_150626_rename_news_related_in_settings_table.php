<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameNewsRelatedInSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('settings', 'news_approval_enable')){
            Schema::table('settings', function (Blueprint $table) {
                $table->renameColumn('news_approval_enable', 'pinboard_approval_enable');
                $table->renameColumn('news_receiver_ids', 'pinboard_receiver_ids');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('settings', 'pinboard_approval_enable')){
            Schema::table('settings', function (Blueprint $table) {
                $table->renameColumn('pinboard_approval_enable', 'news_approval_enable');
                $table->renameColumn('pinboard_receiver_ids', 'news_receiver_ids');
            });
        }
    }
}
