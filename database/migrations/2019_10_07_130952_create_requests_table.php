<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('requests', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category_id')->unsigned()->default(0)->index('service_requests_category_id_foreign');
			$table->integer('unit_id')->unsigned()->default(0)->index('service_requests_unit_id_foreign');
			$table->integer('tenant_id')->unsigned()->default(0)->index('service_requests_tenant_id_foreign');
			$table->string('request_format', 30);
			$table->string('title', 191);
			$table->text('description', 65535);
			$table->integer('status')->unsigned()->default(1);
			$table->integer('priority')->unsigned()->default(1);
			$table->integer('internal_priority')->unsigned()->default(1);
			$table->integer('qualification')->unsigned()->default(0);
			$table->boolean('location')->nullable();
			$table->boolean('payer')->nullable();
			$table->string('component', 191)->nullable();
			$table->boolean('capture_phase')->nullable();
			$table->boolean('room')->nullable();
			$table->date('due_date')->nullable();
			$table->dateTime('solved_date')->nullable();
			$table->dateTime('reactivation_date')->nullable();
			$table->integer('resolution_time')->default(0)->comment('in seconds');
			$table->smallInteger('active_reminder')->default(0);
			$table->integer('days_left_due_date')->unsigned()->default(0);
			$table->integer('reminder_user_id')->unsigned()->nullable()->index('service_requests_reminder_user_id_foreign');
			$table->string('sent_reminder_user_ids', 191)->default('');
			$table->smallInteger('is_public')->default(0);
			$table->smallInteger('notify_email')->default(0);
			$table->timestamps();
			$table->softDeletes();
			$table->integer('visibility')->unsigned()->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('requests');
	}

}
