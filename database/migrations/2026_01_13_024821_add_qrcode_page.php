<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // เพิ่มหน้า qrcode ลงในตาราง page_contents
        DB::table('page_contents')->insert([
            'page_key' => 'qrcode',
            'title' => 'QR Code', // ค่า default
            'content' => '<p>รายละเอียด QR Code...</p>',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        DB::table('page_contents')->where('page_key', 'qrcode')->delete();
    }
};