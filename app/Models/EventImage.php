<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventImage extends Model
{
    public $timestamps = false;
    public $table = 'event_images';
    protected $fillable = ['event_id', 'image_url', 'file_id'];
}
