<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index() {
        
        $roles = Role::with('permissions')->orderBy('id', 'asc')->get();
        $viewAllIndex = $viewIndex = $editIndex = $deleteIndex = true;
        $msg = '';

        //if auth user does not have 'Roles-all' permission
        if(Auth::user()->cannot('viewAll', Role::class)) {
            $viewAllIndex = false;
            $msg = 'You do not have permissions to view roles page';
        }
        
        //if auth user do not have 'Roles-view' permission
        if(Auth::user()->cannot('view', Role::class)) {
            $viewIndex = false;
        }

        //if auth user do not have 'Roles-edit' permission
        if(Auth::user()->cannot('edit', Role::class)) {
            $editIndex = false;
        }

        //if auth user do not have 'Roles-delete' permission
        if(Auth::user()->cannot('delete', Role::class)) {
            $deleteIndex = false;
        }

        return response()->Json([
            'viewAll_index' => $viewAllIndex,
            'view_index' => $viewIndex,
            'edit_index' => $editIndex,
            'delete_index' => $deleteIndex,
            'message' => $msg,
            'data' => $roles,
        ]);
    }

    public function show($id) {

        $role = Role::with('permissions')->find($id);
        $index = true;
        $msg = '';

        //if auth user do not have 'Roles-view' permission
        if(Auth::user()->cannot('view', Role::class)) {
            $index = false;
            $msg = 'You do not have access to view role details';       
        }

        return response()->Json([
            'index' => $index,
            'message' => $msg,
            'data' => $role,            
        ]);
    }

    public function create() {
        $index = true;
        $msg = '';

        //if auth user do not have 'Roles-create' permission
        if(Auth::user()->cannot('create', Role::class)) {
            $index = false;
            $msg = 'You do not have access to create new Role';
        }       

        return response()->json([
            'index' => $index,
            'message' => $msg
        ]);
    }

    public function store(Request $request) {

        //if auth user do not have 'Roles-create' permission
        if(Auth::user()->cannot('create', Role::class)) {
            return response()->json([
                'response_index' => true,
                'response_type' => 'Error',
                'response_message' => ['You are not authorized to create new role'],
            ]);
        }

        $validator = Validator::make($request->all(), [
            'newRole' => 'required|unique:roles,name',
        ]);

        if ($validator->fails()) {
            $message = [];

            foreach(array_values($validator->errors()->toArray()) as $val) {
                $message[] = $val;           
            }
            
            $res = [
                'response_index' => 'true',
                'response_type' => 'Error',
                'response_message' => $message,
            ];
            return response()->Json($res, 200);
        }

        $newRole = Role::create([
            'name' => $request['newRole'],
        ]);

        if($newRole) {
            $res = [
                'response_index' => 'true',
                'response_type' => 'Success',
                'response_message' => ['New Role Created Successfully'],
            ];
            return response()->Json($res);
        }
    }

    public function edit($id) {
        $role = Role::find($id);
        $grantedPermissions = $role->permissions;
        $grantedPermissionsId = $role->permissions->pluck('id');
        $index = true;
        $msg = '';

        //if auth user do not have 'Roles-edit' permission
        if(Auth::user()->cannot('edit', Role::class)) {
            $index = false;
            $msg = 'You do not have permissions to edit role';
        }

        $notGrantedPermissions = Permission::where(function($query) use($grantedPermissionsId){
            foreach($grantedPermissionsId as $id) {
                $query->where('id', '!=', $id);
            }
        })->orderBy('name', 'asc')->get();

        return response()->Json([
            'role' => $role,
            'granted_permissions' => $grantedPermissions,
            'not_granted_permissions' => $notGrantedPermissions,
            'index' => $index,
            'message' => $msg,
        ]);
    }

    public function update(Request $request, $id) {

        $role = Role::find($id);

        //if auth user do not have 'Roles-edit' permission
        if(Auth::user()->cannot('edit', Role::class)) {
            return response()->json([
                'response_index' => true,
                'response_type' => 'Error',
                'response_message' => ['You are not authorized to Edit role'],
            ]);
        }

        //if request user is super admin
        if(Auth::user()->cannot('edit_or_delete_super_admin', $role)) {
            return response()->json([
                'response_index' => true,
                'response_type' => 'Error',
                'response_message' => ['Super Admin account can not be edited to deleted'],
            ]);           
        }


        $permIds = $request->data['permIds'];

        foreach($permIds as $id) {
            $perm = Permission::find($id);

            if($request->data['type'] == 'Added') {
                $query = $role->permissions()->attach($perm);
            }
            elseif($request->data['type'] == 'Removed') {
                $query = $role->permissions()->detach($perm);
            }
        }
        if($query) {
            $res = [
                'response_index' => 'true',
                'response_type' => 'Success',
                'response_message' => ['Permission has been ' . $request->data['type'] . ' Successfully'],
            ];
            return response()->Json($res);
        }
    }

    public function destroy($id) {
        $role = Role::find($id);

        //if auth user do not have 'Roles-delete' permission
        if(Auth::user()->cannot('delete', Role::class)) {
            return response()->json([
                'response_index' => true,
                'response_type' => 'Error',
                'response_message' => ['You do not have permission to delete role'],
            ]);
        }

        //if request user is super admin
        if(Auth::user()->cannot('edit_or_delete_super_admin', $role)) {
            return response()->json([
                'response_index' => true,
                'response_type' => 'Error',
                'response_message' => ['Super Admin account can not be edited to deleted'],
            ]);           
        }

        if($role->delete()){
            $res = [
                'response_index' => true,
                'response_type' => 'Success',
                'response_message' => [$role->name . ' Deleted Successfully'],
            ];
            return response()->Json($res);
        }
    }
}
