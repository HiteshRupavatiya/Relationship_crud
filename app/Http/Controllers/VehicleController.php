<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Traits\ResponceMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    use ResponceMessage;

    public function list()
    {
        $vehicles = Vehicle::with('passenger', 'drivers')->get();
        if ($vehicles) {
            return $this->Success('Vehicles Fetched Successfully', $vehicles);
        }
        return $this->DataNotFound();
    }

    public function create(Request $request)
    {
        $validateVehicle = Validator::make($request->all(), [
            'vehicle_number' => 'required|alpha_num|min:10|max:15|unique:vehicles,vehicle_number',
            'passenger_id'   => 'required|numeric|exists:passengers,id'
        ]);

        if ($validateVehicle->fails()) {
            return $this->ErrorResponse($validateVehicle);
        }

        $vehicle = Vehicle::create($request->only(
            [
                'vehicle_number',
                'passenger_id'
            ]
        ));

        return $this->Success('Vehicle Created Successfully', $vehicle);
    }

    public function get($id)
    {
        $vehicle = Vehicle::find($id);
        if ($vehicle) {
            return $this->Success('Vehicle Fetched Successfully', $vehicle);
        }
        return $this->DataNotFound();
    }

    public function update(Request $request, $id)
    {
        $validateVehicle = Validator::make($request->all(), [
            'vehicle_number' => 'required|alpha_num|min:10|max:15|unique:vehicles,vehicle_number',
        ]);

        if ($validateVehicle->fails()) {
            return $this->ErrorResponse($validateVehicle);
        }

        $vehicle = Vehicle::find($id);

        if ($vehicle) {
            $vehicle->update($request->only(
                [
                    'vehicle_number'
                ]
            ));

            return $this->Success('Vehicle Updated Successfully');
        }
        return $this->DataNotFound();
    }

    public function delete($id)
    {
        $vehicle = Vehicle::find($id);
        if ($vehicle) {
            $vehicle->delete();
            return $this->Success('Vehicle Deleted Successfully');
        }
        return $this->DataNotFound();
    }
}
