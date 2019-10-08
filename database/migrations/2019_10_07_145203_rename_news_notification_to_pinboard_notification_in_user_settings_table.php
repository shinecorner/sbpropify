<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameNewsNotificationToPinboardNotificationInUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('user_settings', 'news_notification')){
            Schema::table('user_settings', function (Blueprint $table) {
                $table->renameColumn('news_notification', 'pinboard_notification');
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
        if (Schema::hasColumn('user_settings', 'pinboard_notification')){
            Schema::table('user_settings', function (Blueprint $table) {
                $table->renameColumn('pinboard_notification', 'news_notification');
            });
        }
    }

}
