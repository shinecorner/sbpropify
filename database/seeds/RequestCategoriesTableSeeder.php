<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RequestCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('request_categories')->truncate();
        DB::unprepared(file_get_contents(database_path('sql' . DIRECTORY_SEPARATOR . 'service_request_categories.sql')));
        Schema::enableForeignKeyConstraints();
    }
}
