<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;

class PromotionSeeder extends Seeder
{
    public function run()
    {
        // สร้างข้อมูลก้อนที่ 1: การสมัครสมาชิก
        Promotion::create([
            'main_title' => 'การสมัครสมาชิก',
            'subtitle' => 'สามารถสมัครได้ 2 ช่องทางคือ แบบ walk in และ แบบออนไลน์ ผ่านช่องทางไลน์',
            'image_url' => 'https://ik.imagekit.io/demo/img/image4.jpeg', // รูปตัวอย่าง
        ]);

        // สร้างข้อมูลก้อนที่ 2: สิทธิประโยชน์
        Promotion::create([
            'main_title' => 'สิทธิประโยชน์รักษาพยาบาลสำหรับสมาชิก',
            'subtitle' => 'ซื้อหุ้น ร้านสหกรณ์มหาวิทยาลัยเชียงใหม่ รับสิทธิพิเศษอะไรบ้าง',
            'image_url' => 'https://ik.imagekit.io/demo/img/image5.jpeg', // รูปตัวอย่าง
        ]);
    }
}