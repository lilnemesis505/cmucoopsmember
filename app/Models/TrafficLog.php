<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrafficLog extends Model
{
    use HasFactory;
    
    // อนุญาตให้บันทึกฟิลด์เหล่านี้
    protected $fillable = ['page_name', 'ip_address'];
}
