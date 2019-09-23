<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsInServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->smallInteger('active_reminder')->after('resolution_time')->default(0);
            $table->integer('days_left_due_date')->unsigned()->default(0)->after('active_reminder');
            $table->integer('reminder_user_id')->unsigned()->nullable()->after('days_left_due_date');
            $table->string('sent_reminder_user_ids')->after('reminder_user_id')->default('');
            $table->foreign('reminder_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropForeign('service_requests_reminder_user_id_foreign');
            $table->dropColumn('active_reminder', 'days_left_due_date', 'reminder_user_id', 'sent_reminder_user_ids');
        });
    }
}
