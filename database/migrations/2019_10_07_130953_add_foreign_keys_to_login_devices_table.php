<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToLoginDevicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('login_devices', function(Blueprint $table)
		{
			$table->foreign('tenant_id')->references('id')->on('tenants')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('login_devices', function(Blueprint $table)
		{
			$table->dropForeign('login_devices_tenant_id_foreign');
			$table->dropForeign('login_devices_user_id_foreign');
		});
	}

}
