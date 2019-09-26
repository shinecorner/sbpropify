<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenamePostPermissionsToPinboard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Permission::where('name', 'list-post')->update([
            'name' => 'list-pinboard',
            'display_name' => 'List Pinboards',
            'description' => 'list all pinboards',
        ]);

        \App\Models\Permission::where('name', 'view-post')->update([
            'name' => 'view-pinboard',
            'display_name' => 'View Pinboard',
            'description' => 'view pinboard',
        ]);

        \App\Models\Permission::where('name', 'add-post')->update([
            'name' => 'add-pinboard',
            'display_name' => 'Add Pinboard',
            'description' => 'add pinboard',
        ]);

        \App\Models\Permission::where('name', 'edit-post')->update([
            'name' => 'edit-pinboard',
            'display_name' => 'Edit Pinboard',
            'description' => 'edit existing pinboard',
        ]);

        \App\Models\Permission::where('name', 'delete-post')->update([
            'name' => 'delete-pinboard',
            'display_name' => 'Delete Pinboard',
            'description' => 'delete existing pinboard',
        ]);

        \App\Models\Permission::where('name', 'publish-post')->update([
            'name' => 'publish-pinboard',
            'display_name' => 'Publish Pinboard',
            'description' => 'publish pinboard',
        ]);

        \App\Models\Permission::where('name', 'pin-post')->update([
            'name' => 'pin-pinboard',
            'display_name' => 'Pin Pinboard',
            'description' => 'pin pinboard',
        ]);

        \App\Models\Permission::where('name', 'assign-post')->update([
            'name' => 'assign-pinboard',
            'display_name' => 'Assign Pinboard',
            'description' => 'assign pinboard',
        ]);

        \App\Models\Permission::where('name', 'list_views-post')->update([
            'name' => 'list_views-pinboard',
            'display_name' => 'List views of Pinboard',
            'description' => 'list views of pinboard',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
