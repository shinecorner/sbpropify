<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToRequestCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('request_categories', function(Blueprint $table)
		{
			$table->foreign('parent_id', 'service_request_categories_parent_id_foreign')->references('id')->on('request_categories')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('request_categories', function(Blueprint $table)
		{
			$table->dropForeign('service_request_categories_parent_id_foreign');
		});
	}

}
