<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRenamingRelatedPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Permission::where('name', 'list-product')->update([
            'name' => 'list-listing',
            'display_name' => 'List Listings',
            'description' => 'list all listings',
        ]);

        \App\Models\Permission::where('name', 'view-product')->update([
            'name' => 'view-listing',
            'display_name' => 'View Listing',
            'description' => 'view listing',
        ]);

        \App\Models\Permission::where('name', 'add-product')->update([
            'name' => 'add-listing',
            'display_name' => 'Add Listing',
            'description' => 'add listing',
        ]);

        \App\Models\Permission::where('name', 'edit-product')->update([
            'name' => 'edit-listing',
            'display_name' => 'Edit Listing',
            'description' => 'edit existing listing',
        ]);

        \App\Models\Permission::where('name', 'delete-product')->update([
            'name' => 'delete-listing',
            'display_name' => 'Delete Listing',
            'description' => 'delete existing listing',
        ]);

        \App\Models\Permission::where('name', '(un)publish-product')->update([
            'name' => '(un)publish-listing',
            'display_name' => 'Publish Listing',
            'description' => 'publish listing',
        ]);

        \App\Models\Permission::where('name', 'list-request')->update([
            'name' => 'list-request',
            'display_name' => 'List Requests',
            'description' => 'list all Requests',
        ]);

        \App\Models\Permission::where('name', 'add-request')->update([
            'name' => 'add-request',
            'display_name' => 'Add Requests',
            'description' => 'add request',
        ]);

        \App\Models\Permission::where('name', 'edit-request')->update([
            'name' => 'edit-request',
            'display_name' => 'Edit Requests',
            'description' => 'edit existing request',
        ]);

        \App\Models\Permission::where('name', 'delete-request')->update([
            'name' => 'delete-request',
            'display_name' => 'Delete Requests',
            'description' => 'delete existing request',
        ]);

        \App\Models\Permission::where('name', 'assign-request')->update([
            'name' => 'assign-request',
            'display_name' => 'Assign property manager or admin to the request',
            'description' => 'Assign property manager or admin to the request',
        ]);

        \App\Models\Permission::where('name', 'add_media_upload-product')->update([
            'name' => 'add_media_upload-listing',
            'display_name' => 'Add media upload listing',
            'description' => 'add media upload listing',
        ]);

        \App\Models\Permission::where('name', 'delete_media_upload-product')->update([
            'name' => 'delete_media_upload-listing',
            'display_name' => 'Add media upload listing',
            'description' => 'add media upload listing',
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
