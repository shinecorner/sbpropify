<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('commentable_type', 191);
			$table->bigInteger('commentable_id')->unsigned();
			$table->integer('parent_id')->unsigned()->nullable()->index('comments_parent_id_foreign');
			$table->text('comment', 65535);
			$table->boolean('is_approved')->default(0);
			$table->integer('user_id')->unsigned()->nullable();
			$table->timestamps();
			$table->index(['commentable_type','commentable_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('comments');
	}

}
