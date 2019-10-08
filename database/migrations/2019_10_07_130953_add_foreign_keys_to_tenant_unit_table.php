<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTenantUnitTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tenant_unit', function(Blueprint $table)
		{
			$table->foreign('tenant_id')->references('id')->on('tenants')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('unit_id')->references('id')->on('units')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tenant_unit', function(Blueprint $table)
		{
			$table->dropForeign('tenant_unit_tenant_id_foreign');
			$table->dropForeign('tenant_unit_unit_id_foreign');
		});
	}

}
