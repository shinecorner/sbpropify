<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('address_id')->unsigned()->default(0)->index('real_estates_address_id_foreign');
			$table->smallInteger('login_variation')->default(1);
			$table->smallInteger('login_variation_2_slider')->default(0);
			$table->boolean('email_powered_by')->default(0);
			$table->string('name', 191);
			$table->string('email', 191)->nullable();
			$table->string('phone', 191)->nullable();
			$table->string('language', 191)->nullable();
			$table->string('logo', 191)->nullable();
			$table->string('circle_logo', 191)->nullable();
			$table->string('tenant_logo', 191)->nullable();
			$table->string('pdf_font_family', 191)->nullable();
			$table->string('favicon_icon', 191)->nullable();
			$table->string('accent_color', 60)->nullable();
			$table->string('primary_color', 60)->nullable();
			$table->string('primary_color_lighter', 191)->default('#c55a9059');
			$table->integer('blank_pdf')->unsigned()->default(0);
			$table->integer('quarter_enable')->unsigned()->default(1);
			$table->boolean('gocaution_enable')->default(0);
			$table->boolean('cleanify_enable')->default(0);
			$table->integer('free_apartments_enable')->unsigned()->default(1);
			$table->string('free_apartments_url', 191)->nullable();
			$table->string('cleanify_email', 191)->nullable();
			$table->text('opening_hours', 65535)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('listing_approval_enable')->unsigned()->default(0);
			$table->integer('news_approval_enable')->unsigned()->default(0);
			$table->integer('comment_update_timeout')->unsigned()->default(60);
			$table->string('iframe_url', 1024)->default('');
			$table->boolean('iframe_enable')->default(0);
			$table->boolean('contact_enable')->default(0);
			$table->text('news_receiver_ids')->nullable();
			$table->string('mail_host', 191)->nullable();
			$table->integer('mail_port')->unsigned()->nullable();
			$table->string('mail_username', 191)->nullable();
			$table->string('mail_password', 191)->nullable();
			$table->string('mail_encryption', 191)->nullable();
			$table->string('mail_from_address', 191)->nullable();
			$table->string('mail_from_name', 191)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('settings');
	}

}
