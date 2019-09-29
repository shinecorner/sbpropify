<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRolesVlaues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Role::where('name', 'service')->update(['name' => 'provider']);
        \App\Models\Role::where('name', 'registered')->update(['name' => 'tenant']);
        \App\Models\Role::where('name', 'super_admin')->delete();
        \App\Models\Role::where('name', 'homeowner')->delete();
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
