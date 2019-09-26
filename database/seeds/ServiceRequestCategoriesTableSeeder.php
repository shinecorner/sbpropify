<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ServiceRequestCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('service_request_categories')->truncate();
        DB::unprepared(file_get_contents(database_path('sql' . DIRECTORY_SEPARATOR . 'service_request_categories.sql')));
        Schema::enableForeignKeyConstraints();
    }
}
