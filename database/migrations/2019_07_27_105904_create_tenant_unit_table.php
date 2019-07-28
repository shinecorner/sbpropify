<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenantUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_unit', function (Blueprint $table) {
            $table->integer('tenant_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->primary(['tenant_id', 'unit_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenant_unit');
    }
}
