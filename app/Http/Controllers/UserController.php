<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Traits\Error;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use Error, Helpers;
    public function index(Request $request)
    {
        $users = User::with('roles.permissions')->get();
        $users = $users->map(
            fn($user) => $this->extractPermissionsFromUser($user)
        );
        return response()->json($users);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required'],
            ]);

            $validated['password'] = Hash::make($validated['password']);

            $user = new User();
            foreach ($validated as $key => $val) {
                $user->{$key} = $val;
            }
            $user->save();

            if (isset($request->roles) && is_array($request->roles)) {
                // removing super admin role if it is exists on the role list;
                // so there is no possibility to add super-admin role for newly created users
                $superAdminRole = Role::where('name', 'super-admin')->first();
                $roles = array_filter(
                    $request->roles,
                    fn($roleId) => $roleId !== $superAdminRole->id
                );

                $user->roles()->sync($roles);
            }

            return response()->json($user);
        } catch (\Exception $error) {
            return $this->errorResponse($error);
        }
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'sometimes'],
                'email' => [
                    'required',
                    'email',
                    'sometimes',
                    Rule::unique('users')->ignore($request->userId),
                ],
                'password' => ['required', 'sometimes'],
            ]);

            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }

            $user = User::with('roles')->find($request->userId);
            if (!$user) {
                throw new \Exception('Error|User not found--404', 13333);
            }

            $usersSuperAdminRole = $user->roles->firstWhere(
                'name',
                'super-admin'
            );
            if ($usersSuperAdminRole) {
                throw new \Exception(
                    'Error|Super admin user can\'t be updated--401',
                    13333
                );
            }

            foreach ($validated as $key => $val) {
                $user->{$key} = $val;
            }
            $user->save();

            if (isset($request->roles) && is_array($request->roles)) {
                // removing super admin role if it is exists on the role list;
                // so there is no possibility to add super-admin role for updated users
                $superAdminRole = Role::where('name', 'super-admin')->first();

                $roles = [];
                if ($superAdminRole) {
                    $roles = array_filter(
                        $request->roles,
                        fn($roleId) => $roleId !== $superAdminRole->id
                    );
                } else {
                    $roles = $request->roles;
                }

                $user->roles()->sync($roles);
            }

            return response()->json($user);
        } catch (\Exception $error) {
            return $this->errorResponse($error);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $user = User::with('roles')->find($request->userId);
            if (!$user) {
                throw new \Exception('Error|User not found--404', 13333);
            }

            $superAdminRole = $user->roles->firstWhere('name', 'super-admin');
            if ($superAdminRole) {
                throw new \Exception(
                    'Error|Super admin user can\'t be deleted--401',
                    13333
                );
            }

            $user->delete();

            return response()->json([], 204);
        } catch (\Exception $error) {
            return $this->errorResponse($error);
        }
    }
}
