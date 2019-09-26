<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixQuarterTableData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        update_district_to_quarter(\App\Models\Quarter::class, ['name']);
        \App\Models\Quarter::get(['id', 'quarter_format'])->each(function ($district) {
            $district->quarter_format = str_replace('DI', 'QT',  $district->quarter_format);
            $district->save();
        });

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
