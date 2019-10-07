<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBuildingAssigneesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('building_assignees', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('building_id')->unsigned()->index('building_assignees_building_id_foreign');
			$table->integer('assignee_id')->unsigned();
			$table->string('assignee_type', 191);
			$table->dateTime('created_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('building_assignees');
	}

}
