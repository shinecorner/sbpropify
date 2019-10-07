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
        Schema::table('user_settings', function (Blueprint $table) {
            $table->renameColumn('pinboard_notification', 'pinboard_notification');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pinboard_notification_in_user_settings', function (Blueprint $table) {
            $table->renameColumn('pinboard_notification', 'pinboard_notification');

        });
    }
}
