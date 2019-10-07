<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPinboardViewTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pinboard_view', function(Blueprint $table)
		{
			$table->foreign('pinboard_id', 'post_view_post_id_foreign')->references('id')->on('pinboard')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('tenant_id', 'post_view_tenant_id_foreign')->references('id')->on('tenants')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pinboard_view', function(Blueprint $table)
		{
			$table->dropForeign('post_view_post_id_foreign');
			$table->dropForeign('post_view_tenant_id_foreign');
		});
	}

}
