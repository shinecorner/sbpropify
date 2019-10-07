<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTenantRentContractsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tenant_rent_contracts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tenant_id')->unsigned()->index('tenant_rent_contracts_tenant_id_foreign');
			$table->integer('building_id')->unsigned()->nullable()->index('tenant_rent_contracts_building_id_foreign');
			$table->integer('unit_id')->unsigned()->nullable()->index('tenant_rent_contracts_unit_id_foreign');
			$table->smallInteger('type')->nullable()->default(1);
			$table->smallInteger('duration')->nullable()->default(1);
			$table->smallInteger('status')->nullable()->default(1);
			$table->string('rent_contract_format', 191)->nullable();
			$table->smallInteger('deposit_type')->nullable()->default(1);
			$table->smallInteger('deposit_status')->nullable()->default(1);
			$table->integer('deposit_amount')->nullable()->default(0);
			$table->decimal('monthly_rent_net')->nullable()->default(0.00);
			$table->decimal('monthly_rent_gross')->nullable()->default(0.00);
			$table->integer('monthly_maintenance')->nullable()->default(0);
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tenant_rent_contracts');
	}

}
