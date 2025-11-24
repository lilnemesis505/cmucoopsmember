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
    Schema::create('members', function (Blueprint $table) {
        $table->id();
        $table->string('member_id')->unique()->nullable(); // รหัสสมาชิก
        $table->string('id_card')->nullable();     // เลขบัตร ปชช.
        $table->string('title_name')->nullable();  // คำนำหน้า
        $table->string('first_name')->nullable();  // ชื่อ
        $table->string('last_name')->nullable();   // นามสกุล
        $table->string('nation')->nullable();      // สัญชาติ
        // ใช้ string เก็บวันที่ไปก่อนเพื่อป้องกัน format error จาก excel 
        // หรือถ้า excel เป็น date format มาตรฐาน ให้ใช้ $table->date()
        $table->string('registry_date')->nullable(); 
        $table->string('phone')->nullable();       // เบอร์โทร

        // ที่อยู่
        $table->string('loc_addr')->nullable();
        $table->string('tambon')->nullable();
        $table->string('amphur')->nullable();
        $table->string('province')->nullable();
        $table->string('zip_code')->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
