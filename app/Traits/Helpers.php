<?php

namespace App\Traits;

use App\Models\User;

trait Helpers
{
    public function extractPermissionsFromUser(User $user): User
    {
        $permissions = collect();

        foreach ($user->roles as $role) {
            $permissions = $permissions->merge($role->permissions);
        }

        $permissions = $permissions
            ->flatten()
            ->unique('id')
            ->values();

        $user->permissions = $permissions;

        return $user;
    }
}
