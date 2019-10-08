<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServiceProvidersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('service_providers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default(0)->index('service_providers_user_id_foreign');
			$table->integer('address_id')->unsigned()->default(0)->index('service_providers_address_id_foreign');
			$table->string('service_provider_format', 30);
			$table->string('category', 191);
			$table->string('name', 191);
			$table->string('email', 191);
			$table->string('phone', 191);
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('service_providers');
	}

}
