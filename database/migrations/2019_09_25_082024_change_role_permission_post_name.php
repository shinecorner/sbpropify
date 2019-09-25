<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRolePermissionPostName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Permission::where('name', 'post-located-post')->delete();
        \App\Models\Permission::where('name', 'post-request_tenant')->delete();
        \App\Models\Permission::where('name', 'post-request_service')->delete();
        \App\Models\Permission::where('name', 'edit-request_tenant')->delete();
        \App\Models\Permission::where('name', 'edit-request_service')->delete();

        \App\Models\Permission::where('name', 'post-user')->update([
            'name' => 'add-user',
            'display_name' => 'Add User',
        ]);
        \App\Models\Permission::where('name', 'post-tenant')->update([
            'name' => 'add-tenant',
            'display_name' => 'Add Tenant',
        ]);
        \App\Models\Permission::where('name', 'post-comment')->update([
            'name' => 'add-comment',
            'display_name' => 'Add Comment',
        ]);
        \App\Models\Permission::where('name', 'post-post')->update([
            'name' => 'add-post',
            'display_name' => 'Add Post',
        ]);
        \App\Models\Permission::where('name', 'post-product')->update([
            'name' => 'add-product',
            'display_name' => 'Add Product',
        ]);
        \App\Models\Permission::where('name', 'post-provider')->update([
            'name' => 'add-provider',
            'display_name' => 'Add service provider',
        ]);
        \App\Models\Permission::where('name', 'post-request')->update([
            'name' => 'add-request',
            'display_name' => 'Add ServiceRequests',
            'description' => 'add serviceRequest',
        ]);
        \App\Models\Permission::where('name', 'edit-request')->update([
            'display_name' => 'Edit ServiceRequests',
            'description' => 'edit existing serviceRequest',
        ]);
        \App\Models\Permission::where('name', 'post-building')->update([
            'name' => 'add-building',
            'display_name' => 'Add Building',
        ]);
        \App\Models\Permission::where('name', 'post-address')->update([
            'name' => 'add-address',
            'display_name' => 'Add Address',
        ]);
        \App\Models\Permission::where('name', 'post-unit')->update([
            'name' => 'add-unit',
            'display_name' => 'Add Unit',
        ]);
        \App\Models\Permission::where('name', 'post-property_manager')->update([
            'name' => 'add-property_manager',
            'display_name' => 'Add property manager',
        ]);
        \App\Models\Permission::where('name', 'post-quarter')->update([
            'name' => 'add-quarter',
            'display_name' => 'Add quarter',
        ]);
        \App\Models\Permission::where('name', 'post-template')->update([
            'name' => 'add-template',
            'display_name' => 'Add template',
        ]);
        \App\Models\Permission::where('name', 'post-service_request_category')->update([
            'name' => 'add-service_request_category',
            'display_name' => 'Add service_request_category',
        ]);
        \App\Models\Permission::where('name', 'post-cleanify_request')->update([
            'name' => 'add-cleanify_request',
            'display_name' => 'Add cleanify request',
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
