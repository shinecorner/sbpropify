<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuarterAssigneesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quarter_assignees', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('quarter_id')->unsigned()->index('quarter_assignees_quarter_id_foreign');
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
		Schema::drop('quarter_assignees');
	}

}
