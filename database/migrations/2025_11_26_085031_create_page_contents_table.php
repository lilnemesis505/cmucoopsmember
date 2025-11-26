<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('page_contents', function (Blueprint $table) {
        $table->id();
        $table->string('page_key')->unique(); // เช่น 'member', 'board' เอาไว้แยกหน้า
        $table->string('title')->nullable();    // หัวข้อหลัก
        $table->string('subtitle')->nullable(); // หัวข้อรอง
        $table->longText('content')->nullable(); // เนื้อหา (เก็บ HTML ได้ยาวๆ)
        $table->json('images')->nullable();      // เก็บลิงก์รูปภาพหลายรูป (JSON)
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_contents');
    }
};
