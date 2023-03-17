<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use App\Traits\ResponceMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PassengerController extends Controller
{
    use ResponceMessage;

    public function list()
    {
        $passengers = Passenger::with('drivers', 'vehicles')->get();
        if ($passengers) {
            return $this->Success('Passengers Fetched Successfully', $passengers);
        }
        return $this->DataNotFound();
    }

    public function create(Request $request)
    {
        $validatePassenger = Validator::make($request->all(), [
            'name' => 'required|alpha|min:5|max:30|unique:passengers,name'
        ]);

        if ($validatePassenger->fails()) {
            return $this->ErrorResponse($validatePassenger);
        }

        $passenger = Passenger::create($request->only(
            [
                'name'
            ]
        ));

        return $this->Success('Passenger Created Successfully', $passenger);
    }

    public function get($id)
    {
        $passenger = Passenger::find($id);
        if ($passenger) {
            return $this->Success('Passenger Fetched Successfully', $passenger);
        }
        return $this->DataNotFound();
    }

    public function update(Request $request, $id)
    {
        $validatePassenger = Validator::make($request->all(), [
            'name' => 'required|alpha|min:5|max:30|unique:passengers,name'
        ]);

        if ($validatePassenger->fails()) {
            return $this->ErrorResponse($validatePassenger);
        }

        $passenger = Passenger::find($id);

        if ($passenger) {
            $passenger->update($request->only(
                [
                    'name'
                ]
            ));

            return $this->Success('Passenger Updated Successfully');
        }
        return $this->DataNotFound();
    }

    public function delete($id)
    {
        $passenger = Passenger::find($id);
        if ($passenger) {
            $passenger->delete();
            return $this->Success('Passenger Deleted Successfully');
        }
        return $this->DataNotFound();
    }
}
