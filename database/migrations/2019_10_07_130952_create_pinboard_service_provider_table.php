<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePinboardServiceProviderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pinboard_service_provider', function(Blueprint $table)
		{
			$table->integer('service_provider_id')->unsigned()->index('post_service_provider_service_provider_id_foreign');
			$table->integer('pinboard_id')->unsigned()->index('post_service_provider_post_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pinboard_service_provider');
	}

}
