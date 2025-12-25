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
    Schema::create('traffic_logs', function (Blueprint $table) {
        $table->id();
        $table->string('page_name'); // เก็บชื่อหน้า เช่น 'member', 'xcademy'
        $table->string('ip_address')->nullable(); // เก็บ IP
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traffic_logs');
    }
};
