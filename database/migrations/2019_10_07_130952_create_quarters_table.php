<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuartersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quarters', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('address_id')->unsigned()->nullable()->index('quarters_address_id_foreign');
			$table->smallInteger('count_of_buildings')->nullable()->default(0);
			$table->string('quarter_format', 30);
			$table->string('name', 191);
			$table->text('description', 65535)->nullable();
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
		Schema::drop('quarters');
	}

}
