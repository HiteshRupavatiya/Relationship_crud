<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    public function list()
    {
        $schools = School::with('students', 'standards')->get();
        return response()->json([
            'status'  => true,
            'message' => 'Schools Fetched Successfully',
            'schools' => $schools
        ]);
    }

    public function create(Request $request)
    {
        $validateSchool = Validator::make($request->all(), [
            'school_name' => 'required|string|min:5|max:20|unique:schools,school_name',
        ]);

        if ($validateSchool->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Errors',
                'errors'  => $validateSchool->errors()
            ]);
        }

        $school = School::create($request->only(
            [
                'school_name',
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'School Created Successfully',
            'school'  => $school
        ]);
    }

    public function get($id)
    {
        $school = School::findOrFail($id);
        if ($school) {
            return response()->json([
                'status'  => true,
                'message' => 'School Fetched Successfully',
                'school'  => $school
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validateSchool = Validator::make($request->all(), [
            'school_name' => 'required|string|min:5|max:20|unique:schools,school_name',
        ]);

        if ($validateSchool->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Errors',
                'errors'  => $validateSchool->errors()
            ]);
        }

        $school = School::findOrFail($id);

        $school->update($request->only(
            [
                'school_name',
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'School Updated Successfully'
        ]);
    }

    public function delete($id)
    {
        $school = School::findOrFail($id);
        if ($school) {
            $school->delete();
            return response()->json([
                'status'  => true,
                'message' => 'School Deleted Successfully'
            ]);
        }
    }
}
