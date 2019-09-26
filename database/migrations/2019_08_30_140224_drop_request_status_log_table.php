<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropRequestStatusLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('request_status_log');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('request_status_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('request_id')->unsigned();
            $table->tinyInteger('old_status')->unsigned();
            $table->tinyInteger('new_status')->unsigned();
            $table->date('started_at')->comment('when start new status');
            $table->foreign('request_id')->references('id')->on('service_requests')->onDelete('cascade');
        });
        \Illuminate\Support\Facades\DB::select('ALTER TABLE `request_status_log` CHANGE `started_at` `started_at` DATETIME NOT NULL COMMENT \'when start new status\';');
    }
}
