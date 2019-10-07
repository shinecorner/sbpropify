<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPinboardServiceProviderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pinboard_service_provider', function(Blueprint $table)
		{
			$table->foreign('pinboard_id', 'post_service_provider_post_id_foreign')->references('id')->on('pinboard')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('service_provider_id', 'post_service_provider_service_provider_id_foreign')->references('id')->on('service_providers')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pinboard_service_provider', function(Blueprint $table)
		{
			$table->dropForeign('post_service_provider_post_id_foreign');
			$table->dropForeign('post_service_provider_service_provider_id_foreign');
		});
	}

}
