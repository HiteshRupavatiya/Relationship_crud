<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_name',
    ];

    public function videos()
    {
        return $this->morphedByMany(Video::class, 'taggable');
    }

    public function songs()
    {
        return $this->morphedByMany(Song::class, 'taggable');
    }
}
