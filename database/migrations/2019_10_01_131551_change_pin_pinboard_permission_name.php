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
        \App\Models\TemplateCategory::where('name', 'pinned_pinboard')->update([
            'name' => 'announcement_pinboard'
        ]);
        \App\Models\Template::where('name', 'Pinboard - pinned_pinboard')->update([
            'name' => 'Pinboard - announcement_pinboard'
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
