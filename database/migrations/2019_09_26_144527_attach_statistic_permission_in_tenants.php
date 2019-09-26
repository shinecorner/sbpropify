<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AttachStatisticPermissionInTenants extends Migration
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
            $role->attachPermissionIfNotExits('view-tenants_statistics');
            $role->attachPermissionIfNotExits('list-product');
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
            $role->detachPermissionIfExits('view-tenants_statistics');
            $role->detachPermissionIfExits('list-product');
        }
    }
}
