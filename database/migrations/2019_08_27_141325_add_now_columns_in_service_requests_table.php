<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNowColumnsInServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->string('room')->after('qualification')->nullable();
            $table->string('capture_phase')->after('qualification')->nullable();
            $table->string('component')->after('qualification')->nullable();
            $table->string('payer')->after('qualification')->nullable();
            $table->tinyInteger('location')->after('qualification')->nullable();
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
            $table->dropColumn('room', 'capture_phase', 'component', 'payer', 'location');
        });
    }
}
