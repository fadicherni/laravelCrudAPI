<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pet extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'pet_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'pet_tags', 'pet_id', 'tag_id');
    }

    public function attachPhotos($data)
    {
        if ($data["added"]) {
            foreach ($data["added"] as $file) {
                $this->photos()->create([
                    'url' => file_upload($file, 'pets/' . $this->id . '/images'),
                    'data' => request('data'),
                    'pet_id' => $this->id,
                ]);
            }
        }
    }

    public function updatePhotos($data)
    {
        if (isset($data["deleted"])) {
            foreach ($data["deleted"] as $attachment_id) {
                $attachment = Photo::find($attachment_id);
                if ($attachment) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $attachment->url));
                    $attachment->delete();
                }
            }
        }
        
        if ($data["added"]) {
            foreach ($data["added"] as $file) {
                $this->photos()->create([
                    'url' => file_upload($file, 'pets/' . $this->id . '/images'),
                    'pet_id' => $this->id,
                ]);
            }
        }
    }

}
