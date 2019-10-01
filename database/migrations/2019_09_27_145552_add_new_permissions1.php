<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewPermissions1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $role = \App\Models\Role::whereName('registered')->first();
        if ($role) {
            $role->attachPermissionIfNotExits('add-request');
            $role->attachPermissionIfNotExits('list-pinboard');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $role = \App\Models\Role::whereName('registered')->first();
        if ($role) {
            $role->detachPermissionIfExits('add-request');
            $role->detachPermissionIfExits('list-pinboard');
        }
    }
}
