<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToQuarterServiceProviderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('quarter_service_provider', function(Blueprint $table)
		{
			$table->foreign('quarter_id', 'district_service_provider_district_id_foreign')->references('id')->on('quarters')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('service_provider_id', 'district_service_provider_service_provider_id_foreign')->references('id')->on('service_providers')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('quarter_service_provider', function(Blueprint $table)
		{
			$table->dropForeign('district_service_provider_district_id_foreign');
			$table->dropForeign('district_service_provider_service_provider_id_foreign');
		});
	}

}
