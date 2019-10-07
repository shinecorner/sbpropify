<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePinboardViewTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pinboard_view', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('pinboard_id')->unsigned();
			$table->integer('tenant_id')->unsigned()->index('post_view_tenant_id_foreign');
			$table->integer('views')->unsigned();
			$table->timestamps();
			$table->unique(['pinboard_id','tenant_id'], 'post_view_post_id_tenant_id_unique');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pinboard_view');
	}

}
