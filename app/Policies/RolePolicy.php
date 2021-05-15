<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function viewAll(User $user) {
        $perms = $user->role->permissions->all();

        foreach($perms as $perm) {
            if($perm->name == 'Roles-all') {
                return true;
            }
        }

        return false;       
    }

    public function view(User $user) {
        $perms = $user->role->permissions->all();

        foreach($perms as $perm) {
            if($perm->name == 'Roles-view') {
                return true;
            }
        }

        return false;       
    }

    public function create(User $user) {
        $perms = $user->role->permissions->all();

        foreach($perms as $perm) {
            if($perm->name == 'Roles-create') {
                return true;
            }
        }

        return false;       
    }

    public function edit(User $user) {
        $perms = $user->role->permissions->all();

        foreach($perms as $perm) {
            if($perm->name == 'Roles-edit') {
                return true;
            }
        }

        return false;       
    }

    public function delete(User $user) {
        $perms = $user->role->permissions->all();

        foreach($perms as $perm) {
            if($perm->name == 'Roles-delete') {
                return true;
            }
        }

        return false;       
    }

    public function edit_or_delete_super_admin(User $user, Role $role) {

        if($role->name == 'Super Admin') {
            return false;
        }
        return true;
    }
}
