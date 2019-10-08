<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('loc_countries', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
			$table->string('code', 191);
			$table->string('alpha_3', 191);
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
		Schema::drop('loc_countries');
	}

}
