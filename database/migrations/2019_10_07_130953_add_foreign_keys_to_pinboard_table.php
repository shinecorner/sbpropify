<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPinboardTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pinboard', function(Blueprint $table)
		{
			$table->foreign('user_id', 'posts_user_id_foreign')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pinboard', function(Blueprint $table)
		{
			$table->dropForeign('posts_user_id_foreign');
		});
	}

}
