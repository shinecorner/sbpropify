<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnnouncementEmailReceptionistsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('announcement_email_receptionists', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('pinboard_id')->unsigned()->index('pinned_email_receptionists_post_id_foreign');
			$table->string('tenant_ids', 191)->nullable();
			$table->string('failed_tenant_ids', 191)->nullable();
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
		Schema::drop('announcement_email_receptionists');
	}

}
