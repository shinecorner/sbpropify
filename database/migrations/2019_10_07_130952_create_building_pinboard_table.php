<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBuildingPinboardTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('building_pinboard', function(Blueprint $table)
		{
			$table->integer('building_id')->unsigned()->index('building_post_building_id_foreign');
			$table->integer('pinboard_id')->unsigned()->index('building_post_post_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('building_pinboard');
	}

}
