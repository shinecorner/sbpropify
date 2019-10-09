<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteTenantUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::drop('tenant_unit');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('tenant_unit', function(Blueprint $table)
        {
            $table->integer('tenant_id')->unsigned();
            $table->integer('unit_id')->unsigned()->index('tenant_unit_unit_id_foreign');
            $table->primary(['tenant_id','unit_id']);
            $table->foreign('tenant_id')->references('id')->on('tenants')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }
}
