<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function list()
    {
        $roles = Role::with('user')->get();
        return response()->json([
            'status'  => true,
            'message' => 'Roles Fetched Successfully',
            'roles'   => $roles
        ]);
    }

    public function create(Request $request)
    {
        $validateRole = Validator::make($request->all(), [
            'role_name' => 'required|alpha|max:20|unique:roles,role_name',
        ]);

        if ($validateRole->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Errors',
                'errors'  => $validateRole->errors()
            ]);
        }

        $role = Role::create($request->only(
            [
                'role_name',
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Role Created Successfully',
            'role'    => $role
        ]);
    }

    public function get($id)
    {
        $role = Role::findOrFail($id);
        if ($role) {
            return response()->json([
                'status'  => true,
                'message' => 'Role Fetched Successfully',
                'role'    => $role
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validateRole = Validator::make($request->all(), [
            'role_name' => 'required|alpha|max:20|unique:roles,role_name',
        ]);

        if ($validateRole->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Errors',
                'errors'  => $validateRole->errors()
            ]);
        }

        $role = Role::findOrFail($id);

        $role->update($request->only(
            [
                'role_name',
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Role Updated Successfully'
        ]);
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);
        if ($role) {
            $role->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Role Deleted Successfully'
            ]);
        }
    }
}
