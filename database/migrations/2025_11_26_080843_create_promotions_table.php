<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('main_title')->nullable(); // หัวข้อหลัก
            $table->text('subtitle')->nullable();       // รายละเอียดรอง
            $table->string('image_url')->nullable();    // ลิงก์รูปภาพ
            $table->string('file_id')->nullable();      // ID รูปใน ImageKit (ไว้ลบ)
            
            // ไม่ใส่ $table->timestamps(); ตามที่ขอ
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotions');
    }
};