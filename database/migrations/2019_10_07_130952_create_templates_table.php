<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTemplatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('templates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category_id')->unsigned()->default(0)->index('templates_category_id_foreign');
			$table->integer('type')->unsigned()->default(1);
			$table->string('name', 191);
			$table->string('subject', 191);
			$table->text('body', 16777215)->nullable();
			$table->boolean('default')->default(0);
			$table->boolean('system')->default(0);
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
		Schema::drop('templates');
	}

}
