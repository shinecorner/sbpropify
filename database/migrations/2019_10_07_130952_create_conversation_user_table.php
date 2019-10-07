<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConversationUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conversation_user', function(Blueprint $table)
		{
			$table->integer('conversation_id')->unsigned()->index('conversation_user_conversation_id_foreign');
			$table->integer('user_id')->unsigned()->index('conversation_user_user_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('conversation_user');
	}

}
