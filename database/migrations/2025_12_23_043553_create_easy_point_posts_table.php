<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // ในไฟล์ migration xxxx_create_easy_point_posts_table.php
public function up()
{
    Schema::create('easy_point_posts', function (Blueprint $table) {
        $table->id();
        $table->string('title');            // หัวข้อ
        $table->string('subtitle')->nullable(); // หัวข้อรอง
        $table->longText('content')->nullable(); // เนื้อหา
        $table->string('cover_image')->nullable(); // รูปปก
        $table->json('images')->nullable();
        $table->timestamps();      // รูปประกอบ (Gallery)
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('easy_point_posts');
    }
};
