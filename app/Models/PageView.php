<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    use HasFactory;

    // ต้องอนุญาตให้บันทึก 2 ช่องนี้
    protected $fillable = ['page_url', 'user_agent'];
}