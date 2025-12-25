<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('slider'); // 'slider' หรือ 'static'
            $table->string('image_url');
            $table->string('file_id')->nullable(); // เก็บ fileId ของ ImageKit
            $table->timestamps();
        });
    }

    public function down()
    { 
        Schema::dropIfExists('banners');
    }
}; 