<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTenantUnitTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tenant_unit', function(Blueprint $table)
		{
			$table->integer('tenant_id')->unsigned();
			$table->integer('unit_id')->unsigned()->index('tenant_unit_unit_id_foreign');
			$table->primary(['tenant_id','unit_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tenant_unit');
	}

}
