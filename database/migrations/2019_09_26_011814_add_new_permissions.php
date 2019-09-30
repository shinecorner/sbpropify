<?php

use Illuminate\Database\Migrations\Migration;

class AddNewPermissions extends Migration
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $roles = \App\Models\Role::whereIn('name', ['super_admin', 'administrator', 'manager'])->get();
        if ($roles->count() == 3) {
            $newPermissions = $this->getNewPerms();

            \Illuminate\Support\Facades\DB::beginTransaction();
            foreach ($newPermissions as $p) {
                \App\Models\Permission::where(['name' =>  $p[0]])->delete();
            }
            \Illuminate\Support\Facades\DB::commit();
        }
    }

    protected function getNewPerms()
    {
        return [
            //statistics
            ['view-tenants_statistics', 'View tenants statistics', 'view tenants statistics'],
            ['view-requests_statistics', 'View requests statistics', 'view requests statistics'],
            ['view-buildings_statistics', 'View buildings statistics', 'view buildings statistics'],
            ['view-all_statistics', 'View all statistics', 'view all statistics'],
            ['view-pie_chart_statistics', 'View pie chart statistics', 'view pie chart statistics'],
            ['view-donut_chart_statistics', 'View donut chart statistics', 'view donut chart statistics'],
            ['view-heat_map_statistics', 'View heat map statistics', 'view heat map statistics'],
            // Tag
            ['list-tag', 'List tag', 'list tag'],
            ['view-tag', 'View tag', 'view tag'],
            ['add-tag', 'Add tag', 'add tag'],
            ['edit-tag', 'Edit tag', 'edit existing tag'],
            ['delete-tag', 'Delete tag', 'delete existing tag'],
            // Translation
            ['list-translation', 'List translation', 'list translation'],
            ['view-translation', 'View translation', 'view translation'],
            ['add-translation', 'Add translation', 'add translation'],
            ['edit-translation', 'Edit translation', 'edit existing translation'],
            ['delete-translation', 'Delete translation', 'delete existing translation'],

            ['assign-quarter', 'Assign property manager, user quarter', 'Assign property manager, user quarter'],
            ['assign-unit', 'Assigned related to unit', 'assigned related to unit'],
        ];
    }
}
