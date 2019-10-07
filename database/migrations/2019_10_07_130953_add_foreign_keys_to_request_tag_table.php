<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToRequestTagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('request_tag', function(Blueprint $table)
		{
			$table->foreign('request_id')->references('id')->on('requests')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('tag_id')->references('id')->on('tags')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('request_tag', function(Blueprint $table)
		{
			$table->dropForeign('request_tag_request_id_foreign');
			$table->dropForeign('request_tag_tag_id_foreign');
		});
	}

}
