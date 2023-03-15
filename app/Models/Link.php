<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'description',
        'link_list_id',
    ];

    public function link_list()
    {
        return $this->belongsTo(LinkList::class);
    }
}
