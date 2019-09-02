<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowRules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $role = \App\Models\Role::whereName('service')->first();
        if ($role) {
            $role->attachPermissionIfNotExits('view-district');
            $role->attachPermissionIfNotExits('view-property_manager');
            $role->attachPermissionIfNotExits('view-building');
            $role->attachPermissionIfNotExits('view-tenant');
            $role->attachPermissionIfNotExits('assign-request');
            $role->attachPermissionIfNotExits('view-address');
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
