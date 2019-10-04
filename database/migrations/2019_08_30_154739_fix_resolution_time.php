<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixResolutionTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $requests = \App\Models\Request::whereNotNull('solved_date')->get(['id', 'created_at', 'solved_date']);
        foreach ($requests as $request) {
            $request->resolution_time = $request->solved_date->diffInSeconds($request->created_at);
            $request->save();
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
