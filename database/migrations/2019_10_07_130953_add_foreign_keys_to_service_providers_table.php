<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToServiceProvidersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('service_providers', function(Blueprint $table)
		{
			$table->foreign('address_id')->references('id')->on('loc_addresses')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
		Schema::table('service_providers', function(Blueprint $table)
		{
			$table->dropForeign('service_providers_address_id_foreign');
			$table->dropForeign('service_providers_user_id_foreign');
		});
	}

}
