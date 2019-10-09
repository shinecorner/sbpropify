<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixRequastsResolutionTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Request::where('resolution_time', 0)
            ->where('status', \App\Models\Request::StatusDone)
            ->get()
            ->each(function ($request) {
                $request->resolution_time = $request->updated_at->diffInSeconds($request->created_at);
                $request->save();
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
