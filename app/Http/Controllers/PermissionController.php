<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index() {
        $permissions = Permission::with('roles')->orderBy('name', 'asc')->paginate(8);
        $viewAllIndex = $viewIndex = $editIndex = $deleteIndex = true;
        $msg = '';

        //if auth user does not have 'Permissions-all' permission
        if(Auth::user()->cannot('viewAll', Permission::class)) {
            $viewAllIndex = false;
            $msg = 'You do not have permissions to view permissions page';
        }
        
        //if auth user do not have 'Permissions-view' permission
        if(Auth::user()->cannot('view', Permission::class)) {
            $viewIndex = false;
        }

        //if auth user do not have 'Permissions-edit' permission
        if(Auth::user()->cannot('edit', Permission::class)) {
            $editIndex = false;
        }

        //if auth user do not have 'Permissions-delete' permission
        if(Auth::user()->cannot('delete', Permission::class)) {
            $deleteIndex = false;
        }

        return response()->Json([
            'viewAll_index' => $viewAllIndex,
            'view_index' => $viewIndex,
            'edit_index' => $editIndex,
            'delete_index' => $deleteIndex,
            'message' => $msg,
            'data' => $permissions,
        ]);
    }

    public function show($id) {
        $permission = Permission::with('roles')->find($id);
        $index = true;
        $msg = '';

        //if auth user do not have 'Permissions-view' permission
        if(Auth::user()->cannot('view', Permission::class)) {
            $index = false;
            $msg = 'You do not have access to view permission details';       
        }

        return response()->Json([
            'index' => $index,
            'message' => $msg,
            'data' => $permission,            
        ]);
    }

    public function create() {
        //if auth user do not have 'Permission-create' permission
        if(Auth::user()->cannot('create', Permission::class)) {
            return response()->json([
                'index' => false,
                'message' => 'You do not have access to create permissions'
            ]);
        }   
    }

    public function store(Request $request) {

        //if auth user do not have 'Permission-create' permission
        if(Auth::user()->cannot('create', Permission::class)) {
            return response()->json([
                'response_index' => true,
                'response_type' => 'Error',
                'response_message' => ['You are not authorized to create new permission'],
            ]);
        }

        $validator = Validator::make($request->all(), [
            'newPermission' => 'required|unique:permissions,name',
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

        $superAdmin = Role::where('name', 'Super Admin')->first();

        $newPermission = Permission::create([
            'name' => $request['newPermission'],
        ]);

        if($newPermission) {
            $superAdmin->permissions()->attach($newPermission);

            $res = [
                'response_index' => 'true',
                'response_type' => 'Success',
                'response_message' => ['New Permission Created Successfully'],
            ];
            return response()->Json($res);
        }
    }

    public function edit($id) {
        $permission = Permission::find($id);
        $index = true;
        $msg = '';

        //if auth user do not have 'Permissions-edit' permission
        if(Auth::user()->cannot('edit', Permission::class)) {
            $index = false;
            $msg = 'You are not authorized to edit permission';
        }
        return response()->Json([
            'permission' => $permission,
            'index' => $index,
            'message' => $msg,
        ]);      
    }

    public function update(Request $request, $id) {

        //if auth user do not have 'Permissions-edit' permission
        if(Auth::user()->cannot('edit', Permission::class)) {
            return response()->json([
                'response_index' => true,
                'response_type' => 'Error',
                'response_message' => ['You are not authorized to edit permission'],
            ]);
        }

        $validator = Validator::make($request->all(), [
            'data' => 'required|unique:permissions,name'
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

        $perm = Permission::find($id);
        if($perm->update(['name' => $request->data])) {
            $res = [
                'response_index' => 'true',
                'response_type' => 'Success',
                'response_message' => ['The Permission Has Been Updated Successfully'],
            ];
            return response()->Json($res);         
        }
    }

    public function destroy($id) {
        $permission = Permission::find($id);

        //if auth user do not have 'Permission-delete' permission
        if(Auth::user()->cannot('delete', Permission::class)) {
            return response()->json([
                'response_index' => true,
                'response_type' => 'Error',
                'response_message' => ['You are not authorized to delete permission'],
            ]);
        }

        if($permission->delete()){
            $res = [
                'response_index' => 'true',
                'response_type' => 'Success',
                'response_message' => [$permission->name . ' Deleted Successfully'],
            ];
            return response()->Json($res);
        }
    }
}
