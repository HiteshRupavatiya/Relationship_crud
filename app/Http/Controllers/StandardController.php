<?php

namespace App\Http\Controllers;

use App\Models\Standard;
use App\Traits\ResponceMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StandardController extends Controller
{
    use ResponceMessage;

    public function list()
    {
        $standards = Standard::with('school', 'students')->get();
        if ($standards) {
            return $this->Success('Standards Fetched Successfully', $standards);
        }
        return $this->DataNotFound();
    }

    public function create(Request $request)
    {
        $validateStandard = Validator::make($request->all(), [
            'standard_name' => 'required|string|min:5|max:30',
            'school_id'     => 'required|exists:schools,id'
        ]);

        if ($validateStandard->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Errors',
                'errors'  => $validateStandard->errors()
            ]);
        }

        $standard = Standard::create($request->only(
            [
                'standard_name',
                'school_id'
            ]
        ));

        return $this->Success('Standard Created Successfully', $standard);
    }

    public function get($id)
    {
        $standard = Standard::find($id);
        if ($standard) {
            return $this->Success('Standard Fetched Successfully', $standard);
        }
        return $this->DataNotFound();
    }

    public function update(Request $request, $id)
    {
        $validateStandard = Validator::make($request->all(), [
            'standard_name' => 'required|string|min:5|max:30',
        ]);

        if ($validateStandard->fails()) {
            return $this->ErrorResponse($validateStandard);
        }

        $standard = Standard::find($id);

        if ($standard) {
            $standard->update($request->only(
                [
                    'standard_name',
                ]
            ));

            return $this->Success('Standard Updated Successfully');
        }
        return $this->DataNotFound();
    }

    public function delete($id)
    {
        $standard = Standard::find($id);
        if ($standard) {
            $standard->delete();
            return $this->Success('Standard Deleted Successfully');
        }
        return $this->DataNotFound();
    }
}
