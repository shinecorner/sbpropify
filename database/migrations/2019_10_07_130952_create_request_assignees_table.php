<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRequestAssigneesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('request_assignees', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('request_id')->unsigned()->index('request_assignees_request_id_foreign');
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
		Schema::drop('request_assignees');
	}

}
