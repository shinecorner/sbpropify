<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTenantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tenants', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable()->index('tenants_user_id_foreign');
			$table->integer('address_id')->unsigned()->nullable()->index('tenants_address_id_foreign');
			$table->integer('building_id')->unsigned()->nullable()->index('tenants_building_id_foreign');
			$table->integer('unit_id')->unsigned()->nullable()->index('tenants_unit_id_foreign');
			$table->integer('country_id')->unsigned()->nullable()->index('tenants_country_id_foreign');
			$table->integer('rating')->nullable();
			$table->smallInteger('client_type')->default(1);
			$table->string('tenant_format', 30);
			$table->string('nation', 191)->nullable();
			$table->string('review', 191)->nullable();
			$table->string('title', 191);
			$table->string('company', 191)->nullable();
			$table->string('first_name', 191);
			$table->string('last_name', 191);
			$table->date('birth_date');
			$table->string('mobile_phone', 191)->nullable();
			$table->string('private_phone', 191)->nullable();
			$table->string('work_phone', 191)->nullable();
			$table->integer('status')->unsigned()->default(1);
			$table->string('activation_code', 50)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->date('rent_start')->nullable();
			$table->date('rent_end')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tenants');
	}

}
