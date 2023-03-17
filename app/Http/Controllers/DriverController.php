<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Traits\ResponceMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    use ResponceMessage;

    public function list()
    {
        $drivers = Driver::with('vehicle')->get();
        if ($drivers) {
            return $this->Success('Drivers Fetched Successfully', $drivers);
        }
        return $this->DataNotFound();
    }

    public function create(Request $request)
    {
        $validateDriver = Validator::make($request->all(), [
            'driver_name' => 'required|alpha|max:40',
            'vehicle_id'  => 'required|numeric|exists:vehicles,id'
        ]);

        if ($validateDriver->fails()) {
            return $this->ErrorResponse($validateDriver);
        }

        $driver = Driver::create($request->only(
            [
                'driver_name',
                'vehicle_id'
            ]
        ));

        return $this->Success('Driver Created Successfully', $driver);
    }

    public function get($id)
    {
        $driver = Driver::find($id);
        if ($driver) {
            return $this->Success('Driver Fetched Successfully', $driver);
        }
        return $this->DataNotFound();
    }

    public function update(Request $request, $id)
    {
        $validateDriver = Validator::make($request->all(), [
            'driver_name' => 'required|alpha|max:40',
        ]);

        if ($validateDriver->fails()) {
            return $this->ErrorResponse($validateDriver);
        }

        $driver = Driver::find($id);

        if ($driver) {
            $driver->update($request->only(
                [
                    'driver_name'
                ]
            ));
            return $this->Success('Driver Updated Successfully');
        }
        return $this->DataNotFound();
    }

    public function delete($id)
    {
        $driver = Driver::find($id);
        if ($driver) {
            $driver->delete();
            return $this->Success('Driver Deleted Successfully');
        }
        return $this->DataNotFound();
    }
}
