<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToListingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('listings', function(Blueprint $table)
		{
			$table->foreign('address_id', 'products_address_id_foreign')->references('id')->on('loc_addresses')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('quarter_id', 'products_district_id_foreign')->references('id')->on('quarters')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id', 'products_user_id_foreign')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('listings', function(Blueprint $table)
		{
			$table->dropForeign('products_address_id_foreign');
			$table->dropForeign('products_district_id_foreign');
			$table->dropForeign('products_user_id_foreign');
		});
	}

}
