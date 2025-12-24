<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['key', 'title', 'description', 'event_date'];

    // ความสัมพันธ์: 1 Event มีหลายรูป
    public function images()
    {
        return $this->hasMany(EventImage::class);
    }
}