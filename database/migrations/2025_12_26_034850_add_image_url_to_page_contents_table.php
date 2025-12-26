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
        Schema::table('page_contents', function (Blueprint $table) {
            // เพิ่มคอลัมน์ image_url ต่อจาก subtitle
            $table->string('image_url')->nullable()->after('subtitle');
        });
    }

    public function down()
    {
        Schema::table('page_contents', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });
    }
};
