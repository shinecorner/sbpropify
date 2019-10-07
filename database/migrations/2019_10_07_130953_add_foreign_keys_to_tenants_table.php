<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTenantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tenants', function(Blueprint $table)
		{
			$table->foreign('address_id')->references('id')->on('loc_addresses')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('building_id')->references('id')->on('buildings')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('country_id')->references('id')->on('loc_countries')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('unit_id')->references('id')->on('units')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tenants', function(Blueprint $table)
		{
			$table->dropForeign('tenants_address_id_foreign');
			$table->dropForeign('tenants_building_id_foreign');
			$table->dropForeign('tenants_country_id_foreign');
			$table->dropForeign('tenants_unit_id_foreign');
			$table->dropForeign('tenants_user_id_foreign');
		});
	}

}
