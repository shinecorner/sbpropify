<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_settings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default(0)->index('user_settings_user_id_foreign');
			$table->string('language', 191)->default('en');
			$table->string('summary', 191)->default('daily');
			$table->integer('admin_notification')->unsigned()->default(1);
			$table->integer('news_notification')->unsigned()->default(1);
			$table->integer('listing_notification')->unsigned()->default(1);
			$table->integer('service_notification')->unsigned()->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_settings');
	}

}
