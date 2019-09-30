<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CorrectRolePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $allPermissions = \App\Models\Permission::get();
        $tenantPermissions = $allPermissions->whereIn('name', config('permissions.tenant'));
        $managerPermissions = $allPermissions->whereIn('name', config('permissions.manager'));
        $providerPermissions = $allPermissions->whereIn('name', config('permissions.provider'));


        $role = \App\Models\Role::whereName('administrator')->first();
        if ($role) {
            $role->savePermissions($allPermissions);
        }

        $role = \App\Models\Role::whereName('tenant')->first();
        if ($role) {
            $role->savePermissions($tenantPermissions);
        }

        $role = \App\Models\Role::whereName('manager')->first();
        if ($role) {
            $role->savePermissions($managerPermissions);
        }

        $role = \App\Models\Role::whereName('manager')->first();
        if ($role) {
            $role->savePermissions($managerPermissions);
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

