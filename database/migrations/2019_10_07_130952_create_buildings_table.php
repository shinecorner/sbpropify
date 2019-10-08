<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBuildingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('buildings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('quarter_id')->unsigned()->nullable()->index('buildings_district_id_foreign');
			$table->integer('address_id')->unsigned()->default(210)->index('buildings_address_id_foreign');
			$table->string('internal_building_id', 191)->nullable();
			$table->string('building_format', 30);
			$table->decimal('latitude', 10, 7)->nullable();
			$table->decimal('longitude', 10, 7)->nullable();
			$table->smallInteger('contact_enable')->default(1);
			$table->string('name', 191);
			$table->string('description', 191)->nullable();
			$table->string('label', 191)->nullable();
			$table->integer('floor_nr')->unsigned()->default(0);
			$table->integer('basement')->unsigned()->default(0);
			$table->integer('attic')->unsigned()->default(0);
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
		Schema::drop('buildings');
	}

}
