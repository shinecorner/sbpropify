<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestStatusLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_status_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('request_id')->unsigned();
            $table->tinyInteger('old_status')->unsigned();
            $table->tinyInteger('new_status')->unsigned();
            $table->date('old_status_stared_at');
            $table->date('new_status_stared_at');
            $table->foreign('request_id')->references('id')->on('service_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_status_log');
    }
}
