<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameSomePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roles = \App\Models\Role::whereIn('name', ['super_admin', 'administrator', 'manager'])->get();
        if ($roles->count() == 3) {
            $newPermissions = $this->getNewPerms();

            \Illuminate\Support\Facades\DB::beginTransaction();
            foreach ($newPermissions as $p) {
                $permission = \App\Models\Permission::updateOrCreate(
                    [
                        'name' =>  $p[0]
                    ],
                    [
                        'display_name' => $p[1],
                        'description' => $p[2],
                    ]
                );
                foreach ($roles as $role) {
                    $role->attachPermissionIfNotExits($p[0]);
                }
            }
            \Illuminate\Support\Facades\DB::commit();
        }

        $role = \App\Models\Role::whereName('registered')->first();
        if ($role) {
            foreach ($this->getTenantPermissions() as $permission) {
                $role->attachPermissionIfNotExits($permission);
            }
        }

        $role = \App\Models\Role::whereName('service')->first();
        if ($role) {
            foreach ($this->getServicePermissions() as $permission) {
                $role->attachPermissionIfNotExits($permission);
            }
        }
        $roles = \App\Models\Role::whereIn('name', ['administrator', 'manager'])->get();
        if ($roles->count() == 2) {
            foreach ($this->missingPerms() as $permission) {
                $role->attachPermissionIfNotExits($permission);
            }
        }


        update_db_fileds(\App\Models\Permission::class, ['name', 'description'], 'publish', '(un)publish', false);
        update_db_fileds(\App\Models\Permission::class, ['display_name'], 'Publish', '(Un)Publish', false);


        \App\Models\Permission::whereIn('name', ['edit-user_setting', 'view-user_setting', 'send_credentials-tenant', 'download_credentials-tenant'])->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        update_db_fileds(\App\Models\Permission::class, ['name', 'description'], '(un)publish', 'publish', false);
        update_db_fileds(\App\Models\Permission::class, ['display_name'], '(Un)Publish', 'Publish', false);

        $roles = \App\Models\Role::whereIn('name', ['super_admin', 'administrator', 'manager'])->get();
        if ($roles->count() == 3) {
            $newPermissions = $this->getNewPerms();

            \Illuminate\Support\Facades\DB::beginTransaction();
            foreach ($newPermissions as $p) {
                \App\Models\Permission::where(['name' =>  $p[0]])->delete();
            }
            \Illuminate\Support\Facades\DB::commit();
        }

        $role = \App\Models\Role::whereName('registered')->first();
        if ($role) {
            foreach ($this->getTenantPermissions() as $permission) {
                $role->detachPermissionIfExits($permission);
            }
        }

        $role = \App\Models\Role::whereName('service')->first();
        if ($role) {
            foreach ($this->getServicePermissions() as $permission) {
                $role->detachPermissionIfExits($permission);
            }
        }

        $roles = \App\Models\Role::whereIn('name', ['administrator', 'manager'])->get();
        if ($roles->count() == 2) {
            foreach ($this->missingPerms() as $permission) {
                $role->detachPermissionIfExits($permission);
            }
        }

    }

    protected function getNewPerms()
    {
        return [
            ['delete-comment', 'Delete Comment', 'delete existing comment'],
            ['download_pdf-request', 'Download pdf request', 'download pdf request'],
            // internal notice
            ['list-internal_notice', 'List Internal notices', 'list Internal notices'],
            ['view-internal_notice', 'View Internal notice', 'view internal notices'],
            ['add-internal_notice', 'Add Internal notice', 'add internal notices'],
            ['edit-internal_notice', 'Edit Internal notice', 'edit existing internal noticess'],
            ['delete-internal_notice', 'Delete Internal notice', 'delete existing internal notices'],


            ['add_media_upload-quarter', 'Add media upload quarter', 'add media upload quarter'],
            ['delete_media_upload-quarter', 'Add media upload quarter', 'add media upload quarter'],

            ['add_media_upload-building', 'Add media upload building', 'add media upload building'],
            ['delete_media_upload-building', 'Add media upload building', 'add media upload building'],

            ['add_media_upload-pinboard', 'Add media upload pinboard', 'add media upload pinboard'],
            ['delete_media_upload-pinboard', 'Add media upload pinboard', 'add media upload pinboard'],

            ['add_media_upload-product', 'Add media upload product', 'add media upload product'],
            ['delete_media_upload-product', 'Add media upload product', 'add media upload product'],

            ['add_media_upload-tenant', 'Add media upload tenant', 'add media upload tenant'],
            ['delete_media_upload-tenant', 'Add media upload tenant', 'add media upload tenant'],

            ['add_media_upload-request', 'Add media upload request', 'add media upload request'],
            ['delete_media_upload-request', 'Add media upload request', 'add media upload request'],
        ];
    }

    protected function getTenantPermissions()
    {
        return [
            'delete-comment',
            'add_media_upload-quarter',
            'delete_media_upload-quarter',
            'add_media_upload-building',
            'delete_media_upload-building',
            'add_media_upload-pinboard',
            'delete_media_upload-pinboard',
            'add_media_upload-product',
            'delete_media_upload-product',
            'add_media_upload-tenant',
            'delete_media_upload-tenant',
            'add_media_upload-request',
            'delete_media_upload-request',
            'view-pinboard'
        ];
    }

    protected function getServicePermissions()
    {
        return [
            'delete-comment',
            'add_media_upload-quarter',
            'delete_media_upload-quarter',
            'add_media_upload-building',
            'delete_media_upload-building',
            'add_media_upload-pinboard',
            'delete_media_upload-pinboard',
            'add_media_upload-product',
            'delete_media_upload-product',
            'add_media_upload-tenant',
            'delete_media_upload-tenant',
            'add_media_upload-request',
            'delete_media_upload-request'
        ];
    }

    protected function missingPerms() {
        return [
            'list-pinboard',
            'add-pinboard',
            'edit-pinboard',
            'delete-pinboard',
            'publish-pinboard',
            'pin-pinboard',
            'assign-pinboard',
            'list_views-pinboard',
            'list-product',
            'view-product',
            'add-product',
            'edit-product',
            'delete-product',
            'publish-product',
            'list-audit',
            'list-cleanify_request',
            'add-cleanify_request',
        ];

    }
}
