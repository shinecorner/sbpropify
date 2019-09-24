<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAcquisitionColumnInServiceRequestCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_request_categories', function (Blueprint $table) {
            $table->tinyInteger('acquisition')->default(0)->after('has_qualifications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_request_categories', function (Blueprint $table) {
            $table->dropColumn('acquisition');
        });
    }
}
