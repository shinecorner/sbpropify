<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTemplateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('template_categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('parent_id')->unsigned()->nullable()->index('template_categories_parent_id_foreign');
			$table->string('name', 191);
			$table->text('description', 65535);
			$table->string('subject', 191);
			$table->text('body', 65535);
			$table->text('tag_map', 65535)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('type')->unsigned()->default(1);
			$table->boolean('system')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('template_categories');
	}

}
