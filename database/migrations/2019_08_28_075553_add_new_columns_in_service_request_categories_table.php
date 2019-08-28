<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsInServiceRequestCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_request_categories', function (Blueprint $table) {
            $table->string('name_it')->after('name');
            $table->string('name_fr')->after('name');
            $table->string('name_de')->after('name');
            $table->tinyInteger('room')->after('name_it')->nullable();
            $table->tinyInteger('location')->after('room')->nullable();
        });
        \Illuminate\Support\Facades\DB::table('service_request_categories')->update(['name_de' => DB::raw( 'name' )]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_request_categories', function (Blueprint $table) {
            $table->dropColumn('name_it', 'name_fr', 'name_de', 'room', 'location');
        });
    }
}
