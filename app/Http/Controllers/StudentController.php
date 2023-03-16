<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function list()
    {
        $students = Student::with('standard')->get();
        return response()->json([
            'status'   => true,
            'message'  => 'Students Fetched Successfully',
            'students' => $students
        ]);
    }

    public function create(Request $request)
    {
        $validateStudent = Validator::make($request->all(), [
            'student_name' => 'required|string|min:5|max:20',
            'standard_id'  => 'required|exists:standards,id'
        ]);

        if ($validateStudent->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Errors',
                'errors'  => $validateStudent->errors()
            ]);
        }

        $student = Student::create($request->only(
            [
                'student_name',
                'standard_id'
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Student Created Successfully',
            'student' => $student
        ]);
    }

    public function get($id)
    {
        $student = Student::findOrFail($id);
        if ($student) {
            return response()->json([
                'status'  => true,
                'message' => 'Student Fetched Successfully',
                'student' => $student
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validateStudent = Validator::make($request->all(), [
            'student_name' => 'required|string|min:5|max:20',
        ]);

        if ($validateStudent->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Errors',
                'errors'  => $validateStudent->errors()
            ]);
        }

        $student = Student::findOrFail($id);

        $student->update($request->only(
            [
                'student_name',
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Student Updated Successfully'
        ]);
    }

    public function delete($id)
    {
        $student = Student::findOrFail($id);
        if ($student) {
            $student->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Student Deleted Successfully'
            ]);
        }
    }
}
