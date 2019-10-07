<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAuditsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('audits', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user_type', 191)->nullable();
			$table->bigInteger('user_id')->unsigned()->nullable();
			$table->string('event', 191);
			$table->string('auditable_type', 191);
			$table->bigInteger('auditable_id')->unsigned();
			$table->text('old_values', 65535)->nullable();
			$table->text('new_values', 65535)->nullable();
			$table->text('url', 65535)->nullable();
			$table->string('ip_address', 45)->nullable();
			$table->string('user_agent', 191)->nullable();
			$table->string('tags', 191)->nullable();
			$table->timestamps();
			$table->index(['user_id','user_type']);
			$table->index(['auditable_type','auditable_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('audits');
	}

}
