<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePropertyManagersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('property_managers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default(0)->index('property_managers_user_id_foreign');
			$table->string('property_manager_format', 30);
			$table->text('description', 65535)->nullable();
			$table->string('title', 191);
			$table->string('first_name', 191);
			$table->string('last_name', 191);
			$table->string('profession', 191)->nullable();
			$table->string('slogan', 191)->nullable();
			$table->string('xing_url', 191)->nullable();
			$table->string('linkedin_url', 191)->nullable();
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
		Schema::drop('property_managers');
	}

}
