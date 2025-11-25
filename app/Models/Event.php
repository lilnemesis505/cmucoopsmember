<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $timestamps = false;
    public $table = 'events';
    protected $fillable = [
        'key', 
        'title', 
        'description', 
        'event_date' // <--- เพิ่มบรรทัดนี้เข้าไปใน $fillable
    ];

    // ความสัมพันธ์กับรูปภาพ
   public function images()
{
    return $this->hasMany(EventImage::class);
}

    // ดึงเฉพาะรูปแรกมาเป็นปก
    public function coverImage()
    {
        return $this->hasOne(EventImage::class)->oldestOfMany();
    }
    
}