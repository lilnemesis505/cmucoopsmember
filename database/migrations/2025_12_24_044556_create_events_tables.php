<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. ตาราง Events (เก็บชื่ออัลบั้ม, รายละเอียด, วันที่)
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // ev1, ev2, ...
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->date('event_date')->nullable();
            $table->timestamps();
        });

        // 2. ตาราง Event Images (เก็บรูปภาพของแต่ละ Event)
        Schema::create('event_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('image_url');
            $table->string('file_id')->nullable(); // File ID จาก ImageKit
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_images');
        Schema::dropIfExists('events');
    }
};
