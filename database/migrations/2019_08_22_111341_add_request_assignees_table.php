<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRequestAssigneesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_assignees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('request_id')->unsigned();;
            $table->integer('assignee_id')->unsigned();
            $table->string('assignee_type');
            $table->timestamp('created_at')->nullable();
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
        Schema::dropIfExists('request_assignees');
    }
}
