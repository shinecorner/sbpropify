<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLoginDevicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('login_devices', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('user_id')->unsigned()->index('login_devices_user_id_foreign');
			$table->integer('tenant_id')->unsigned()->nullable()->index('login_devices_tenant_id_foreign');
			$table->integer('mobile')->unsigned()->default(0);
			$table->integer('desktop')->unsigned()->default(0);
			$table->integer('tablet')->unsigned()->default(0);
			$table->dateTime('created_by');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('login_devices');
	}

}
