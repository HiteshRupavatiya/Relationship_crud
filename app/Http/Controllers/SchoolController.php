<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Traits\ResponceMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    use ResponceMessage;

    public function list()
    {
        $schools = School::with('students', 'standards')->get();
        if ($schools) {
            return $this->Success('Schools Fetched Successfully', $schools);
        }
        return $this->DataNotFound();
    }

    public function create(Request $request)
    {
        $validateSchool = Validator::make($request->all(), [
            'school_name' => 'required|string|min:5|max:20|unique:schools,school_name',
        ]);

        if ($validateSchool->fails()) {
            return $this->ErrorResponse($validateSchool);
        }

        $school = School::create($request->only(
            [
                'school_name',
            ]
        ));

        return $this->Success('School Created Successfully', $school);
    }

    public function get($id)
    {
        $school = School::find($id);
        if ($school) {
            return $this->Success('School Fetched Successfully', $school);
        }
        return $this->DataNotFound();
    }

    public function update(Request $request, $id)
    {
        $validateSchool = Validator::make($request->all(), [
            'school_name' => 'required|string|min:5|max:20|unique:schools,school_name',
        ]);

        if ($validateSchool->fails()) {
            return $this->ErrorResponse($validateSchool);
        }

        $school = School::find($id);

        if ($school) {
            $school->update($request->only(
                [
                    'school_name',
                ]
            ));

            return $this->Success('School Updated Successfully');
        }
        return $this->DataNotFound();
    }

    public function delete($id)
    {
        $school = School::find($id);
        if ($school) {
            $school->delete();
            return $this->Success('School Deleted Successfully');
        }
        return $this->DataNotFound();
    }
}
