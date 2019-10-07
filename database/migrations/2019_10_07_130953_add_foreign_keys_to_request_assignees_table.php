<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToRequestAssigneesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('request_assignees', function(Blueprint $table)
		{
			$table->foreign('request_id')->references('id')->on('requests')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('request_assignees', function(Blueprint $table)
		{
			$table->dropForeign('request_assignees_request_id_foreign');
		});
	}

}
