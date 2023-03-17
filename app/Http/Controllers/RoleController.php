<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Traits\ResponceMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    use ResponceMessage;

    public function list()
    {
        $roles = Role::with('user')->get();
        if ($roles) {
            return $this->Success('Roles Fetched Successfully', $roles);
        }
        return $this->DataNotFound();
    }

    public function create(Request $request)
    {
        $validateRole = Validator::make($request->all(), [
            'role_name' => 'required|alpha|max:20|unique:roles,role_name',
        ]);

        if ($validateRole->fails()) {
            return $this->ErrorResponse($validateRole);
        }

        $role = Role::create($request->only(
            [
                'role_name',
            ]
        ));

        return $this->Success('Role Created Successfully', $role);
    }

    public function get($id)
    {
        $role = Role::find($id);
        if ($role) {
            return $this->Success('Role Fetched Successfully', $role);
        }
        return $this->DataNotFound();
    }

    public function update(Request $request, $id)
    {
        $validateRole = Validator::make($request->all(), [
            'role_name' => 'required|alpha|max:20|unique:roles,role_name',
        ]);

        if ($validateRole->fails()) {
            return $this->ErrorResponse($validateRole);
        }

        $role = Role::find($id);

        if ($role) {
            $role->update($request->only(
                [
                    'role_name',
                ]
            ));

            return $this->Success('Role Updated Successfully');
        }
        return $this->DataNotFound();
    }

    public function delete($id)
    {
        $role = Role::find($id);
        if ($role) {
            $role->delete();
            return $this->Success('Role Deleted Successfully');
        }
        return $this->DataNotFound();
    }
}
