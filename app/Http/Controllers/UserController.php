<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Profile;
use App\Traits\ResponceMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ResponceMessage;

    public function list()
    {
        $profiles = User::with('profile')->has('profile')->get();
        if ($profiles) {
            return $this->Success('Profiles Fetched Successfully', $profiles);
        }
        return $this->DataNotFound();
    }

    public function create(Request $request)
    {
        $validateProfile = Validator::make($request->all(), [
            'image_path'       => 'required|string|max:100',
            'profileable_id'   => 'required|exists:users,id',
        ]);

        if ($validateProfile->fails()) {
            return $this->ErrorResponse($validateProfile);
        }

        $user = User::find($request->profileable_id);

        $profile = new Profile;

        $profile->image_path = $request->image_path;

        $user->profile()->save($profile);

        return $this->Success('Profile Created Successfully', $profile);
    }

    public function get($id)
    {
        $profile = Profile::find($id);
        if ($profile) {
            return $this->Success('Profile Fetched Successfully', $profile);
        }
        return $this->DataNotFound();
    }

    public function update(Request $request)
    {
        $validateProfile = Validator::make($request->all(), [
            'image_path'       => 'required|string|max:100',
            'profileable_id'   => 'required|exists:profiles,profileable_id',
        ]);

        if ($validateProfile->fails()) {
            return $this->ErrorResponse($validateProfile);
        }

        $profile = Profile::find($request->profileable_id);

        $profile->update($request->only(
            [
                'image_path'
            ]
        ));

        return $this->Success('Profile Updated Successfully');
    }

    public function delete($id)
    {
        $profile = Profile::find($id);
        if ($profile) {
            $profile->delete();
            return $this->Success('Profile Deleted Successfully');
        }
        return $this->DataNotFound();
    }
}
