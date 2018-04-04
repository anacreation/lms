<?php
/**
 * Author: Xavier Au
 * Date: 1/3/2018
 * Time: 10:13 AM
 */

namespace Anacreation\Lms\traits;


use Anacreation\Lms\Models\Permission;
use Anacreation\Lms\Models\Role;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;

trait RoleAndPermission
{

    // Relation
    public function roles(): Relation {
        return $this->belongsToMany(Role::class);
    }

    // Accessor
    public function getPermissionsAttribute(): Collection {
        return $this->roles()->with('permissions')->get()->map(function (
            Role $role
        ) {
            return $role->permissions;
        })->flatten()->unique('id');
    }

    // helpers

    public function hasPermission($permission): bool {
        if ($permission instanceof Permission) {
            return !!$this->permissions->first(function (Permission $p) use (
                $permission
            ) {
                return $p->id === $permission->id;
            });
        } elseif (is_string($permission)) {
            return !!$this->permissions->first(function (Permission $p) use (
                $permission
            ) {
                return $p->code === $permission;
            });
        } else {
            return false;
        }
    }

    public function hasAllPermissions(iterable $permissions): bool {
        $check = true;
        $_permissions = $this->permissions;
        foreach ($permissions as $permission) {
            if ($permission instanceof Permission) {
                if (!$_permissions->first(function (Permission $p) use (
                    $permission
                ) {
                    return $p->id === $permission->id;
                })) {
                    $check = false;
                    break;
                };
            } elseif (is_string($permission)) {
                if (!$_permissions->first(function (Permission $p) use (
                    $permission
                ) {
                    return $p->code === $permission;
                })) {
                    $check = false;
                    break;
                };
            } else {
                $check = false;
                break;
            }
        }

        return $check;
    }

    public function isRole($role): bool {
        if ($role instanceof Role) {
            return !!$this->roles()->whereId($role->id)->count() > 0;
        } elseif (is_string($role)) {

            return !!$this->roles()->whereCode($role)->count() > 0;
        } else {
            return false;
        }
    }

    public function assignRole(Role $role): void {
        $this->roles()->save($role);
    }

    public function syncRoles(array $roleIds): void {
        $this->roles()->sync($roleIds);
    }

    public function removeRoles(Role $role): void {
        $this->roles()->detach($role->id);
    }
}