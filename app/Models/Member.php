<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    // ต้องระบุรายชื่อคอลัมน์ที่อนุญาตให้บันทึกข้อมูลได้
    protected $fillable = [
        'member_id',
        'id_card',
        'title_name',
        'first_name',
        'last_name',
        'nation',
        'registry_date',
        'phone',        // เบอร์โทร
        'loc_addr',     // ที่อยู่
        'tambon',
        'amphur',
        'province',
        'zip_code',
    ];
}