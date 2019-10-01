<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewPermissions2 extends Migration
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
            $role->attachPermissionIfNotExits('edit-request');
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
            $role->detachPermissionIfExits('edit-request');
        }
    }

}
