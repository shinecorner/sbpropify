<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUnitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('units', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('building_id')->unsigned()->default(0)->index('units_building_id_foreign');
			$table->string('unit_format', 30);
			$table->integer('type')->unsigned()->default(1);
			$table->string('name', 191);
			$table->string('description', 191);
			$table->integer('floor')->default(0);
			$table->decimal('monthly_rent_net')->nullable()->default(0.00);
			$table->decimal('monthly_rent_gross')->nullable()->default(0.00);
			$table->integer('monthly_maintenance')->nullable()->default(0);
			$table->decimal('room_no')->nullable()->default(0.00);
			$table->integer('basement')->unsigned()->default(0);
			$table->integer('attic')->unsigned()->default(0);
			$table->integer('sq_meter')->unsigned()->default(0);
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('units');
	}

}
