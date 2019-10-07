<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCleanifyRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cleanify_requests', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('form');
			$table->integer('user_id')->unsigned()->nullable()->index('cleanify_requests_user_id_foreign');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cleanify_requests');
	}

}
