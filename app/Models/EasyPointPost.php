<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EasyPointPost extends Model
{
    use HasFactory;

    protected $table = 'easy_point_posts'; // ชื่อตาราง
    protected $fillable = ['title', 'subtitle', 'content', 'cover_image', 'images'];

    protected $casts = [
        'images' => 'array',
    ];
}