<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function list()
    {
        $vehicles = Vehicle::with('passenger', 'drivers')->get();
        return response()->json([
            'status'   => true,
            'message'  => 'Vehicles Fetched Successfully',
            'vehicles' => $vehicles
        ]);
    }

    public function create(Request $request)
    {
        $validateVehicle = Validator::make($request->all(), [
            'vehicle_number' => 'required|alpha_num|min:10|max:15|unique:vehicles,vehicle_number',
            'passenger_id'   => 'required|numeric|exists:passengers,id'
        ]);

        if ($validateVehicle->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Error',
                'errors'  => $validateVehicle->errors()
            ]);
        }

        $vehicle = Vehicle::create($request->only(
            [
                'vehicle_number',
                'passenger_id'
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Vehicle Created Successfully',
            'vehicle' => $vehicle
        ]);
    }

    public function get($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        if ($vehicle) {
            return response()->json([
                'status'  => true,
                'message' => 'Vehicle Fetched Successfully',
                'vehicle' => $vehicle
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validateVehicle = Validator::make($request->all(), [
            'vehicle_number' => 'required|alpha_num|min:10|max:15|unique:vehicles,vehicle_number',
        ]);

        if ($validateVehicle->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Error',
                'errors'  => $validateVehicle->errors()
            ]);
        }

        $vehicle = Vehicle::findOrFail($id);

        $vehicle->update($request->only(
            [
                'vehicle_number'
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Vehicle Updated Successfully'
        ]);
    }

    public function delete($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        if ($vehicle) {
            $vehicle->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Vehicle Deleted Successfully'
            ]);
        }
    }
}
