<?php

namespace App\Http\Controllers;

use App\Models\Standard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StandardController extends Controller
{
    public function list()
    {
        $standards = Standard::with('school', 'students')->get();
        return response()->json([
            'status'    => true,
            'message'   => 'Standards Fetched Successfully',
            'standards' => $standards
        ]);
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

        return response()->json([
            'status'   => true,
            'message'  => 'Standard Created Successfully',
            'standard' => $standard
        ]);
    }

    public function get($id)
    {
        $standard = Standard::findOrFail($id);
        if ($standard) {
            return response()->json([
                'status'   => true,
                'message'  => 'Standard Fetched Successfully',
                'standard' => $standard
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validateStandard = Validator::make($request->all(), [
            'standard_name' => 'required|string|min:5|max:30',
        ]);

        if ($validateStandard->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Errors',
                'errors'  => $validateStandard->errors()
            ]);
        }

        $standard = Standard::findOrFail($id);

        $standard->update($request->only(
            [
                'standard_name',
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Standard Updated Successfully'
        ]);
    }

    public function delete($id)
    {
        $standard = Standard::findOrFail($id);
        if ($standard) {
            $standard->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Standard Deleted Successfully'
            ]);
        }
    }
}
