<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    // 1. ปิดการใช้งาน Timestamps (created_at, updated_at)
    public $timestamps = false;

    // 2. อนุญาตให้แก้ไขข้อมูลได้
    protected $fillable = [
        'main_title',
        'subtitle',
        'image_url',
        'file_id'
    ];
}