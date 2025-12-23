<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EasyPointPost extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'subtitle', 'content', 'cover_image', 'images'];
    

    // แปลง json images เป็น array อัตโนมัติ
    protected $casts = [
        'images' => 'array',
    ];
}