<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAnnouncementEmailReceptionistsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('announcement_email_receptionists', function(Blueprint $table)
		{
			$table->foreign('pinboard_id', 'pinned_email_receptionists_post_id_foreign')->references('id')->on('pinboard')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('announcement_email_receptionists', function(Blueprint $table)
		{
			$table->dropForeign('pinned_email_receptionists_post_id_foreign');
		});
	}

}
