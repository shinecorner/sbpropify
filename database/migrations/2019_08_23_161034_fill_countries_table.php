<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FillCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $countryId = \App\Models\Country::where('name', 'Switzerland')->value('id');
        if (210 == $countryId) {
            Schema::disableForeignKeyConstraints();
            \App\Models\Country::truncate();
            DB::unprepared(file_get_contents(database_path('sql' . DIRECTORY_SEPARATOR . 'loc_countries.sql')));
            $countryId = \App\Models\Country::where('name', 'Switzerland')->value('id');
            \App\Models\Address::where('country_id', 210)->update(['country_id' => $countryId]);
            \App\Models\State::where('country_id', 210)->update(['country_id' => $countryId]);
            Schema::enableForeignKeyConstraints();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
