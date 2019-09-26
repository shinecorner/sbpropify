<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteRequestProviderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('request_provider');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::create('request_provider', function(Blueprint $table) {
            $table->integer('provider_id')->unsigned();
            $table->integer('request_id')->unsigned();
            $table->foreign('provider_id')->references('id')->on('service_providers')->onDelete('cascade');
            $table->foreign('request_id')->references('id')->on('service_requests')->onDelete('cascade');
            $table->primary(['provider_id', 'request_id']);
        });
    }
}
