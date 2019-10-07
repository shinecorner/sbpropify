<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTenantRentContractsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tenant_rent_contracts', function(Blueprint $table)
		{
			$table->foreign('building_id')->references('id')->on('buildings')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('tenant_id')->references('id')->on('tenants')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('unit_id')->references('id')->on('units')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tenant_rent_contracts', function(Blueprint $table)
		{
			$table->dropForeign('tenant_rent_contracts_building_id_foreign');
			$table->dropForeign('tenant_rent_contracts_tenant_id_foreign');
			$table->dropForeign('tenant_rent_contracts_unit_id_foreign');
		});
	}

}
