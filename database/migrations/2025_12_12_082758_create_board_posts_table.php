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
    Schema::create('board_posts', function (Blueprint $table) {
        $table->id();
        $table->string('title');            // หัวข้อหลัก
        $table->string('subtitle')->nullable(); // หัวข้อรอง
        $table->string('cover_image')->nullable(); // รูปปก (โชว์หน้ารวม)
        $table->longText('content')->nullable();   // เนื้อหาข้างใน (Summernote)
        $table->json('images')->nullable();        // รูปแกลเลอรีท้ายเว็บ
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_posts');
    }
};
