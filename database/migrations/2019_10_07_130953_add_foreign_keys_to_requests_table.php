<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('requests', function(Blueprint $table)
		{
			$table->foreign('category_id', 'service_requests_category_id_foreign')->references('id')->on('request_categories')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('reminder_user_id', 'service_requests_reminder_user_id_foreign')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('tenant_id', 'service_requests_tenant_id_foreign')->references('id')->on('tenants')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('unit_id', 'service_requests_unit_id_foreign')->references('id')->on('units')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('requests', function(Blueprint $table)
		{
			$table->dropForeign('service_requests_category_id_foreign');
			$table->dropForeign('service_requests_reminder_user_id_foreign');
			$table->dropForeign('service_requests_tenant_id_foreign');
			$table->dropForeign('service_requests_unit_id_foreign');
		});
	}

}
