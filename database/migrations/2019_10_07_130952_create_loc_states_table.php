<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocStatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('loc_states', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('country_id')->unsigned()->default(0)->index('loc_states_country_id_foreign');
			$table->string('code', 191);
			$table->string('name', 191);
			$table->string('name_de', 191);
			$table->string('name_fr', 191);
			$table->string('name_it', 191);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('loc_states');
	}

}
