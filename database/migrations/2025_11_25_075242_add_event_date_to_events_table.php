<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // เพิ่มคอลัมน์ event_date ชนิด date (เก็บแค่วันที่)
            // nullable() แปลว่าอนุญาตให้ว่างได้ (เผื่อข้อมูลเก่าไม่มีวันที่)
            // after('title') แปลว่าให้แทรกต่อจากช่อง title
            $table->date('event_date')->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // คำสั่งลบฟิลด์ (ถ้าเรา rollback)
            $table->dropColumn('event_date');
        });
    }
};