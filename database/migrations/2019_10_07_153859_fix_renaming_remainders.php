<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixRenamingRemainders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        update_notifications_data_value('news', 'pinboard');
        update_db_fields(\App\Models\Pinboard::class, 'content', 'news', 'pinboard');
        update_db_fields(\App\Models\Autologin::class, 'redirect', 'news', 'pinboard');
        update_db_fields(\OwenIt\Auditing\Models\Audit::class, ['new_values', 'old_values'], 'news', 'pinboard');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
