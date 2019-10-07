<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPinboardQuarterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pinboard_quarter', function(Blueprint $table)
		{
			$table->foreign('quarter_id', 'district_post_district_id_foreign')->references('id')->on('quarters')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('pinboard_id', 'district_post_post_id_foreign')->references('id')->on('pinboard')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pinboard_quarter', function(Blueprint $table)
		{
			$table->dropForeign('district_post_district_id_foreign');
			$table->dropForeign('district_post_post_id_foreign');
		});
	}

}
