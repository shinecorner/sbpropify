<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuarterServiceProviderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quarter_service_provider', function(Blueprint $table)
		{
			$table->integer('quarter_id')->unsigned()->index('district_service_provider_district_id_foreign');
			$table->integer('service_provider_id')->unsigned()->index('district_service_provider_service_provider_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('quarter_service_provider');
	}

}
