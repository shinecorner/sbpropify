<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBuildingPinboardTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('building_pinboard', function(Blueprint $table)
		{
			$table->foreign('building_id', 'building_post_building_id_foreign')->references('id')->on('buildings')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('pinboard_id', 'building_post_post_id_foreign')->references('id')->on('pinboard')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('building_pinboard', function(Blueprint $table)
		{
			$table->dropForeign('building_post_building_id_foreign');
			$table->dropForeign('building_post_post_id_foreign');
		});
	}

}
