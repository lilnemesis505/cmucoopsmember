<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['page_key', 'title', 'subtitle', 'content', 'images'];

    // แปลง JSON ใน Database ให้เป็น Array อัตโนมัติ
    protected $casts = [
        'images' => 'array',
    ];
}