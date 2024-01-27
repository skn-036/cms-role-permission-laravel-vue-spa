<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Traits\Error;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    use Error;
    public function index(Request $request)
    {
        $roles = Role::with('permissions')->get();
        return response()->json($roles);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'unique:roles,name'],
            ]);

            $role = new Role();
            foreach ($validated as $key => $val) {
                $role->{$key} = $val;
            }
            $role->save();

            if (isset($request->permissions) && is_array($request->permissions)) {
                $role->permissions()->sync($request->permissions);
            }
            return response()->json($role);
        } catch (\Exception $error) {
            return $this->errorResponse($error);
        }
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    Rule::unique('roles')->ignore($request->roleId),
                ],
            ]);

            $role = Role::find($request->roleId);
            if (!$role) {
                throw new \Exception('Error|Role not found--404', 13333);
            }
            if ($role->name === 'super-admin') {
                throw new \Exception(
                    'Error|Super admin role can\'t be updated--404',
                    13333
                );
            }

            foreach ($validated as $key => $val) {
                $role->{$key} = $val;
            }
            $role->save();

            if (isset($request->permissions) && is_array($request->permissions)) {
                $role->permissions()->sync($request->permissions);
            }
            return response()->json($role);
        } catch (\Exception $error) {
            return $this->errorResponse($error);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $role = Role::find($request->roleId);
            if (!$role) {
                throw new \Exception('Error|Role not found--404', 13333);
            }
            if ($role->name === 'super-admin') {
                throw new \Exception(
                    'Error|Super admin role can\'t be deleted--404',
                    13333
                );
            }

            $role->delete();
            return response()->json([], 204);
        } catch (\Exception $error) {
            return $this->errorResponse($error);
        }
    }
}
