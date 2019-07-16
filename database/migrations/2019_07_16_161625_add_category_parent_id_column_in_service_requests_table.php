<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryParentIdColumnInServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->integer('category_parent_id')->unsigned()->nullable()->after('category_id');
            $table->foreign('category_parent_id', 'service_requests_category_parent_id_foreign')->references('id')->on('service_request_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropForeign('service_requests_category_parent_id_foreign');
            $table->dropColumn('category_parent_id');
        });
    }
}
