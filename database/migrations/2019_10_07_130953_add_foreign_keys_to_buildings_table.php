<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBuildingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('buildings', function(Blueprint $table)
		{
			$table->foreign('address_id')->references('id')->on('loc_addresses')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('quarter_id', 'buildings_district_id_foreign')->references('id')->on('quarters')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('buildings', function(Blueprint $table)
		{
			$table->dropForeign('buildings_address_id_foreign');
			$table->dropForeign('buildings_district_id_foreign');
		});
	}

}
