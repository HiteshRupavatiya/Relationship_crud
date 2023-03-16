<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_name',
    ];

    public function schools()
    {
        return $this->hasManyThrough(Student::class, Standard::class);
    }

    public function standards()
    {
        return $this->hasMany(Standard::class);
    }
}
