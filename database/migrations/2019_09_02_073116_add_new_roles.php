<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $role = \App\Models\Role::whereName('service')->first();
        $role->attachPermissionIfNotExits('list-district');
        $role->attachPermissionIfNotExits('list-property_manager');
        $role->attachPermissionIfNotExits('list-building');
        $role->attachPermissionIfNotExits('list-tenant');
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
