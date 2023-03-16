<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleUserController extends Controller
{
    public function list()
    {
        $roleUsers = RoleUser::with('user', 'role')->get();
        return response()->json([
            'status'     => true,
            'message'    => 'Role Users Fetched Successfully',
            'role_users' => $roleUsers
        ]);
    }

    public function create(Request $request)
    {
        $validateRoleUser = Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validateRoleUser->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Errors',
                'errors'  => $validateRoleUser->errors()
            ]);
        }

        $roleUser = RoleUser::create($request->only(
            [
                'role_id',
                'user_id'
            ]
        ));

        return response()->json([
            'status'    => true,
            'message'   => 'Role User Created Successfully',
            'role_user' => $roleUser
        ]);
    }

    public function get($id)
    {
        $roleUser = RoleUser::findOrFail($id);
        if ($roleUser) {
            return response()->json([
                'status'    => true,
                'message'   => 'Role User Fetched Successfully',
                'role_user' => $roleUser
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validateRoleUser = Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validateRoleUser->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Errors',
                'errors'  => $validateRoleUser->errors()
            ]);
        }

        $roleUser = RoleUser::findOrFail($id);

        $roleUser->update($request->only(
            [
                'role_id',
                'user_id'
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Role User Updated Successfully'
        ]);
    }

    public function delete($id)
    {
        $roleUser = RoleUser::findOrFail($id);
        if ($roleUser) {
            $roleUser->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Role User Deleted Successfully'
            ]);
        }
    }
}
