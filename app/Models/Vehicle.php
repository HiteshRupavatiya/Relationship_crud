<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_number',
        'passenger_id'
    ];

    public function passenger()
    {
        return $this->belongsTo(Passenger::class);
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }
}
