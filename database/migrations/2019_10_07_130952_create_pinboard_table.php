<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePinboardTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pinboard', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('posts_user_id_foreign');
			$table->integer('type')->unsigned()->default(1);
			$table->smallInteger('sub_type')->nullable();
			$table->integer('status')->unsigned()->default(1);
			$table->integer('visibility')->unsigned()->default(1);
			$table->boolean('category_image')->nullable()->default(0);
			$table->text('content', 65535);
			$table->timestamps();
			$table->softDeletes();
			$table->dateTime('published_at')->nullable();
			$table->boolean('announcement')->default(0);
			$table->integer('category')->unsigned()->nullable();
			$table->smallInteger('is_execution_time')->default(1);
			$table->boolean('execution_period')->default(0);
			$table->dateTime('execution_start')->nullable();
			$table->dateTime('execution_end')->nullable();
			$table->string('title', 1000)->nullable();
			$table->boolean('notify_email')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pinboard');
	}

}
