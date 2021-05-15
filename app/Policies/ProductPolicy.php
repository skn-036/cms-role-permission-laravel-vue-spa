<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
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
            if($perm->name == 'Products-all') {
                return true;
            }
        }

        return false;       
    }

    public function view(User $user) {
        $perms = $user->role->permissions->all();

        foreach($perms as $perm) {
            if($perm->name == 'Products-view') {
                return true;
            }
        }

        return false;       
    }

    public function create(User $user) {
        $perms = $user->role->permissions->all();

        foreach($perms as $perm) {
            if($perm->name == 'Products-create') {
                return true;
            }
        }

        return false;       
    }

    public function edit(User $user) {
        $perms = $user->role->permissions->all();

        foreach($perms as $perm) {
            if($perm->name == 'Products-edit') {
                return true;
            }
        }

        return false;       
    }

    public function delete(User $user) {
        $perms = $user->role->permissions->all();

        foreach($perms as $perm) {
            if($perm->name == 'Products-delete') {
                return true;
            }
        }

        return false;       
    }
}
