<?php

namespace App\Models;

use Zizaco\Entrust\EntrustRole;


/**
 * @SWG\Definition(
 *      definition="Role",
 *      required={"name"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *     @SWG\Property(
 *          property="display_name",
 *          description="Human readable name for the Role. Not necessarily unique and optional.",
 *          type="string"
 *      ),
 *     @SWG\Property(
 *          property="description",
 *          description="A more detailed explanation of what the Role does. Also optional.",
 *          type="string"
 *      ),
 * )
 */
class Role extends EntrustRole
{
    /**
     * @param $permissionName
     */
    public function attachPermissionIfNotExits($permissionName)
    {
        if (! $this->hasPermission($permissionName)) {
            $permission = Permission::whereName($permissionName)->first();
            if ($permission) {
                $this->attachPermission($permission);
            }
        }
    }

    /**
     * @param $permissionName
     */
    public function detachPermissionIfExits($permissionName)
    {
        if ($this->hasPermission($permissionName)) {
            $permission = Permission::whereName($permissionName)->first();
            if ($permission) {
                $this->detachPermission($permission);
            }
        }
    }
}


