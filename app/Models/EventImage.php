<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventImage extends Model
{
    protected $fillable = ['event_id', 'image_url', 'file_id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}