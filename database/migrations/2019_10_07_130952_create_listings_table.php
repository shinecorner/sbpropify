<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateListingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('listings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('products_user_id_foreign');
			$table->integer('type')->unsigned()->default(1);
			$table->integer('status')->unsigned()->default(1);
			$table->integer('visibility')->unsigned()->default(1);
			$table->string('title', 191);
			$table->text('content', 65535);
			$table->string('contact', 191);
			$table->timestamps();
			$table->softDeletes();
			$table->dateTime('published_at')->nullable();
			$table->integer('address_id')->unsigned()->nullable()->index('products_address_id_foreign');
			$table->integer('quarter_id')->unsigned()->nullable()->index('products_district_id_foreign');
			$table->string('price', 191)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('listings');
	}

}
