<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePinboardQuarterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pinboard_quarter', function(Blueprint $table)
		{
			$table->integer('quarter_id')->unsigned()->index('district_post_district_id_foreign');
			$table->integer('pinboard_id')->unsigned()->index('district_post_post_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pinboard_quarter');
	}

}
