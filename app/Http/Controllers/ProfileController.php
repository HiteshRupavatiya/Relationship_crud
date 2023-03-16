<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function list()
    {
        $profiles = User::with('profile')->has('profile')->get();
        return response()->json([
            'status'   => true,
            'message'  => 'Profiles Fetched Successfully',
            'profiles' => $profiles
        ]);
    }

    public function create(Request $request)
    {
        $validateProfile = Validator::make($request->all(), [
            'image_path'       => 'required|string|max:100',
            'profileable_id'   => 'required|exists:users,id',
        ]);

        if ($validateProfile->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Errors',
                'errors'  => $validateProfile->errors()
            ]);
        }

        $user = User::findOrFail($request->profileable_id);

        $profile = new Profile;

        $profile->image_path = $request->image_path;

        $user->profile()->save($profile);

        return response()->json([
            'status'  => true,
            'message' => 'Profile Created Successfully',
            'profile' => $profile
        ]);
    }

    public function get($id)
    {
        $profile = Profile::findOrFail($id);
        if ($profile) {
            return response()->json([
                'status'  => true,
                'message' => 'Profile Fetched Successfully',
                'profile' => $profile
            ]);
        }
    }

    public function update(Request $request)
    {
        $validateProfile = Validator::make($request->all(), [
            'image_path'       => 'required|string|max:100',
            'profileable_id'   => 'required|exists:profiles,profileable_id',
        ]);

        if ($validateProfile->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Errors',
                'errors'  => $validateProfile->errors()
            ]);
        }

        $profile = Profile::findOrFail($request->profileable_id);

        $profile->update($request->only(
            [
                'image_path'
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Profile Updated Successfully',
        ]);
    }

    public function delete($id)
    {
        $profile = Profile::findOrFail($id);
        if ($profile) {
            $profile->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Profile Deleted Successfully'
            ]);
        }
    }
}
