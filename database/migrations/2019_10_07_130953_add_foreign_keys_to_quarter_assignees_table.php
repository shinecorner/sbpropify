<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToQuarterAssigneesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('quarter_assignees', function(Blueprint $table)
		{
			$table->foreign('quarter_id')->references('id')->on('quarters')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('quarter_assignees', function(Blueprint $table)
		{
			$table->dropForeign('quarter_assignees_quarter_id_foreign');
		});
	}

}
