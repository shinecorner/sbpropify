<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRequestCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('request_categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('parent_id')->unsigned()->nullable()->index('service_request_categories_parent_id_foreign');
			$table->string('name', 191);
			$table->string('name_de', 191);
			$table->string('name_fr', 191);
			$table->string('name_it', 191);
			$table->boolean('room')->nullable()->default(0);
			$table->boolean('location')->nullable()->default(0);
			$table->text('description', 65535)->nullable();
			$table->boolean('has_qualifications')->default(0);
			$table->boolean('acquisition')->default(0);
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
		Schema::drop('request_categories');
	}

}
