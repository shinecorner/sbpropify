<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRequestTagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('request_tag', function(Blueprint $table)
		{
			$table->integer('request_id')->unsigned()->index('request_tag_request_id_foreign');
			$table->integer('tag_id')->unsigned();
			$table->primary(['tag_id','request_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('request_tag');
	}

}
