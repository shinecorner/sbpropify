<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToLocAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('loc_addresses', function(Blueprint $table)
		{
			$table->foreign('country_id')->references('id')->on('loc_countries')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('state_id')->references('id')->on('loc_states')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('loc_addresses', function(Blueprint $table)
		{
			$table->dropForeign('loc_addresses_country_id_foreign');
			$table->dropForeign('loc_addresses_state_id_foreign');
		});
	}

}
