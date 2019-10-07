<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTemplateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('template_categories', function(Blueprint $table)
		{
			$table->foreign('parent_id')->references('id')->on('template_categories')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('template_categories', function(Blueprint $table)
		{
			$table->dropForeign('template_categories_parent_id_foreign');
		});
	}

}
