<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuarterAssigneesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quarter_assignees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quarter_id')->unsigned();;
            $table->integer('assignee_id')->unsigned();
            $table->string('assignee_type');
            $table->timestamp('created_at')->nullable();
            $table->foreign('quarter_id')->references('id')->on('quarters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quarter_assignees');
    }
}
