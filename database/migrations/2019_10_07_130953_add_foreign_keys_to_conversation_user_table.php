<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToConversationUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('conversation_user', function(Blueprint $table)
		{
			$table->foreign('conversation_id')->references('id')->on('conversations')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('conversation_user', function(Blueprint $table)
		{
			$table->dropForeign('conversation_user_conversation_id_foreign');
			$table->dropForeign('conversation_user_user_id_foreign');
		});
	}

}
