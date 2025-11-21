<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    public $timestamps = false;
    public $table = 'slides';
    protected $fillable = ['image_url', 'file_id'];
}
