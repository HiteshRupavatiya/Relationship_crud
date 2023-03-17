<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Traits\ResponceMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    use ResponceMessage;

    public function list()
    {
        $students = Student::with('standard')->get();
        if ($students) {
            return $this->Success('Students Fetched Successfully', $students);
        }
        return $this->DataNotFound();
    }

    public function create(Request $request)
    {
        $validateStudent = Validator::make($request->all(), [
            'student_name' => 'required|string|min:5|max:20',
            'standard_id'  => 'required|exists:standards,id'
        ]);

        if ($validateStudent->fails()) {
            return $this->ErrorResponse($validateStudent);
        }

        $student = Student::create($request->only(
            [
                'student_name',
                'standard_id'
            ]
        ));

        return $this->Success('Student Created Successfully', $student);
    }

    public function get($id)
    {
        $student = Student::find($id);
        if ($student) {
            return $this->Success('Student Fetched Successfully', $student);
        }
        return $this->DataNotFound();
    }

    public function update(Request $request, $id)
    {
        $validateStudent = Validator::make($request->all(), [
            'student_name' => 'required|string|min:5|max:20',
        ]);

        if ($validateStudent->fails()) {
            return $this->ErrorResponse($validateStudent);
        }

        $student = Student::find($id);

        if ($student) {
            $student->update($request->only(
                [
                    'student_name',
                ]
            ));

            return $this->Success('Student Updated Successfully');
        }
        return $this->DataNotFound();
    }

    public function delete($id)
    {
        $student = Student::find($id);
        if ($student) {
            $student->delete();
            return $this->Success('Student Deleted Successfully');
        }
        return $this->DataNotFound();
    }
}
