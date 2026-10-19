<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CourseItem extends Model
{
    protected $fillable = ['course_id', 'title', 'description', 'image', 'sort_order'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }
}
