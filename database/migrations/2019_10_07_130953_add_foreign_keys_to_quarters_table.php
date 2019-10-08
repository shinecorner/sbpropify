<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToQuartersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('quarters', function(Blueprint $table)
		{
			$table->foreign('address_id')->references('id')->on('loc_addresses')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('quarters', function(Blueprint $table)
		{
			$table->dropForeign('quarters_address_id_foreign');
		});
	}

}
