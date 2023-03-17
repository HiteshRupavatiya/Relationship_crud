<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use App\Traits\ResponceMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleUserController extends Controller
{
    use ResponceMessage;

    public function list()
    {
        $roleUsers = RoleUser::with('user', 'role')->get();
        if ($roleUsers) {
            return $this->Success('Role Users Fetched Successfully', $roleUsers);
        }
        return $this->DataNotFound();
    }

    public function create(Request $request)
    {
        $validateRoleUser = Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validateRoleUser->fails()) {
            return $this->ErrorResponse($validateRoleUser);
        }

        $roleUser = RoleUser::create($request->only(
            [
                'role_id',
                'user_id'
            ]
        ));

        return $this->Success('Role User Created Successfully', $roleUser);
    }

    public function get($id)
    {
        $roleUser = RoleUser::find($id);
        if ($roleUser) {
            return $this->Success('Role User Fetched Successfully', $roleUser);
        }
        return $this->DataNotFound();
    }

    public function update(Request $request, $id)
    {
        $validateRoleUser = Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validateRoleUser->fails()) {
            return $this->ErrorResponse($validateRoleUser);
        }

        $roleUser = RoleUser::find($id);

        if ($roleUser) {
            $roleUser->update($request->only(
                [
                    'role_id',
                    'user_id'
                ]
            ));

            return $this->Success('Role User Updated Successfully');
        }
        return $this->DataNotFound();
    }

    public function delete($id)
    {
        $roleUser = RoleUser::find($id);
        if ($roleUser) {
            $roleUser->delete();
            return $this->Success('Role User Deleted Successfully');
        }
        return $this->DataNotFound();
    }
}
