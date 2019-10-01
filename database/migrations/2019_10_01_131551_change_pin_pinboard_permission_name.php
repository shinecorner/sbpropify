<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePinPinboardPermissionName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Permission::where('name' , 'pin-pinboard')->update([
            'name' => 'announcement-pinboard',
            'display_name' => 'Announcement Pinboard',
            'description' => 'announcement pinboard'
        ]);
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
