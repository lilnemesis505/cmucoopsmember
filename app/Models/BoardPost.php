<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'subtitle', 'cover_image', 'content', 'images'
    ];

    protected $casts = [
        'images' => 'array', // แปลง JSON เป็น Array อัตโนมัติ
    ];
}