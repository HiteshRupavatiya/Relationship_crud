<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function drivers()
    {
        return $this->hasOneThrough(Driver::class, Vehicle::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
