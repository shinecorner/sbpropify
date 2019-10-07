<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConversationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conversations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('conversationable_type', 191);
			$table->bigInteger('conversationable_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->index(['conversationable_type','conversationable_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('conversations');
	}

}
