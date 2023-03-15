<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PassengerController extends Controller
{
    public function list()
    {
        $passengers = Passenger::with('drivers', 'vehicles')->get();
        return response()->json([
            'status'     => true,
            'message'    => 'Passengers Fetched Successfully',
            'passengers' => $passengers
        ]);
    }

    public function create(Request $request)
    {
        $validatePassenger = Validator::make($request->all(), [
            'name' => 'required|alpha|min:5|max:30|unique:passengers,name'
        ]);

        if ($validatePassenger->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Error',
                'errors'  => $validatePassenger->errors()
            ]);
        }

        $passenger = Passenger::create($request->only(
            [
                'name'
            ]
        ));

        return response()->json([
            'status'    => true,
            'message'   => 'Passenger Created Successfully',
            'passenger' => $passenger
        ]);
    }

    public function get($id)
    {
        $passenger = Passenger::findOrFail($id);
        if ($passenger) {
            return response()->json([
                'status'    => true,
                'message'   => 'Passenger Fetched Successfully',
                'passenger' => $passenger
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validatePassenger = Validator::make($request->all(), [
            'name' => 'required|alpha|min:5|max:30|unique:passengers,name'
        ]);

        if ($validatePassenger->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Error',
                'errors'  => $validatePassenger->errors()
            ]);
        }

        $passenger = Passenger::findOrFail($id);

        $passenger->update($request->only(
            [
                'name'
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Passenger Updated Successfully'
        ]);
    }

    public function delete($id)
    {
        $passenger = Passenger::findOrFail($id);
        if ($passenger) {
            $passenger->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Passenger Deleted Successfully'
            ]);
        }
    }
}
