<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('loc_addresses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('country_id')->unsigned()->default(210)->index('loc_addresses_country_id_foreign');
			$table->integer('state_id')->unsigned()->default(0)->index('loc_addresses_state_id_foreign');
			$table->string('city', 191);
			$table->string('street', 191);
			$table->string('house_num', 191);
			$table->string('zip', 191);
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
		Schema::drop('loc_addresses');
	}

}
