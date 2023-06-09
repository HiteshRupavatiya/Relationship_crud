<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_name',
        'standard_id'
    ];

    public function standard()
    {
        return $this->belongsTo(Standard::class)->with('school');
    }
}
