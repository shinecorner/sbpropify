<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBuildingAssigneesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('building_assignees', function(Blueprint $table)
		{
			$table->foreign('building_id')->references('id')->on('buildings')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('building_assignees', function(Blueprint $table)
		{
			$table->dropForeign('building_assignees_building_id_foreign');
		});
	}

}
