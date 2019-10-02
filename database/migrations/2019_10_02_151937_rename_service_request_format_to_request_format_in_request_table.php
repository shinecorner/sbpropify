<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameServiceRequestFormatToRequestFormatInRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requestS', function (Blueprint $table) {
            $table->renameColumn('service_request_format', 'request_format');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requestS', function (Blueprint $table) {
            $table->renameColumn('request_format', 'service_request_format');
        });
    }
}
