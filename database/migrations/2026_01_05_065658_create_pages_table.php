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
    Schema::create('pages', function (Blueprint $table) {
        $table->id();
        $table->string('key')->unique(); // เช่น 'member_check', 'contact'
        $table->string('title');
        $table->string('subtitle')->nullable();
        $table->text('content')->nullable();
        $table->string('image_url')->nullable(); // รูปปก
        $table->json('images')->nullable(); // Gallery
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
