<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allPermissions = Permission::get();
        $tenantPermissions = $allPermissions->whereIn('name', config('permissions.tenant'));
        $managerPermissions = $allPermissions->whereIn('name', config('permissions.manager'));
        $providerPermissions = $allPermissions->whereIn('name', config('permissions.provider'));


        $RLCAdmin = new Role();
        $RLCAdmin->name = 'administrator';
        $RLCAdmin->display_name = 'Real estate company';
        $RLCAdmin->description = '';
        $RLCAdmin->save();
        $RLCAdmin->attachPermissions($allPermissions);

        $RLCManager = new Role();
        $RLCManager->name = 'manager';
        $RLCManager->display_name = 'Real Estate Employee';
        $RLCManager->description = '';
        $RLCManager->save();
        $RLCManager->attachPermissions($managerPermissions);

        $RLCService = new Role();
        $RLCService->name = 'provider';
        $RLCService->display_name = 'RLC Third part Service';
        $RLCService->description = '';
        $RLCService->save();
        $RLCService->attachPermissions($providerPermissions);

        $RLCUser = new Role();
        $RLCUser->name = 'tenant';
        $RLCUser->display_name = 'Users (tenants)';
        $RLCUser->description = '';
        $RLCUser->save();
        $RLCUser->attachPermissions($tenantPermissions);
    }
}
