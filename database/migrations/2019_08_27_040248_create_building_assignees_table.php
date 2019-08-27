<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildingAssigneesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_assignees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('building_id')->unsigned();;
            $table->integer('assignee_id')->unsigned();
            $table->string('assignee_type');
            $table->timestamp('created_at')->nullable();
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('building_assignees');
    }
}
