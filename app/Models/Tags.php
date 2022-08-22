<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'pet_tags', 'tag_id', 'pet_id');
    }
}
