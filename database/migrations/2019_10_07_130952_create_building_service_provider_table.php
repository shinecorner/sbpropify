<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBuildingServiceProviderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('building_service_provider', function(Blueprint $table)
		{
			$table->integer('building_id')->unsigned()->index('building_service_provider_building_id_foreign');
			$table->integer('service_provider_id')->unsigned()->index('building_service_provider_service_provider_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('building_service_provider');
	}

}
