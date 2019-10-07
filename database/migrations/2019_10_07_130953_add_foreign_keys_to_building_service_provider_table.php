<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBuildingServiceProviderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('building_service_provider', function(Blueprint $table)
		{
			$table->foreign('building_id')->references('id')->on('buildings')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('service_provider_id')->references('id')->on('service_providers')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('building_service_provider', function(Blueprint $table)
		{
			$table->dropForeign('building_service_provider_building_id_foreign');
			$table->dropForeign('building_service_provider_service_provider_id_foreign');
		});
	}

}
