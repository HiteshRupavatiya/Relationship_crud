<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    public function list()
    {
        $drivers = Driver::with('vehicle')->get();
        return response()->json([
            'status'  => true,
            'message' => 'Drivers Fetched Successfully',
            'drivers' => $drivers
        ]);
    }

    public function create(Request $request)
    {
        $validateDriver = Validator::make($request->all(), [
            'driver_name' => 'required|alpha|max:40',
            'vehicle_id'  => 'required|numeric|exists:vehicles,id'
        ]);

        if ($validateDriver->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Error',
                'errors'  => $validateDriver->errors()
            ]);
        }

        $driver = Driver::create($request->only(
            [
                'driver_name',
                'vehicle_id'
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Driver Created Successfully',
            'driver'  => $driver
        ]);
    }

    public function get($id)
    {
        $driver = Driver::findOrFail($id);
        if ($driver) {
            return response()->json([
                'status'  => true,
                'message' => 'Driver Fetched Successfully',
                'driver'  => $driver
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validateDriver = Validator::make($request->all(), [
            'driver_name' => 'required|alpha|max:40',
        ]);

        if ($validateDriver->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Error',
                'errors'  => $validateDriver->errors()
            ]);
        }

        $driver = Driver::findOrFail($id);

        $driver->update($request->only(
            [
                'driver_name'
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Driver Updated Successfully'
        ]);
    }

    public function delete($id)
    {
        $driver = Driver::findOrFail($id);
        if ($driver) {
            $driver->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Driver Deleted Successfully'
            ]);
        }
    }
}
