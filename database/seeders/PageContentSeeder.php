<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class PageContentSeeder extends Seeder
{
    public function run()
    {
        PageContent::updateOrCreate(
            ['page_key' => 'member'],
            [
                'title' => 'สิทธิประโยชน์สำหรับสมาชิก (Members)',
                'subtitle' => 'สมัครสมาชิก ร้านสหกรณ์มหาวิทยาลัยเชียงใหม่',
                'content' => '
                    <ol>
                        <li>พิเศษ สมัครเพียง 100 บาท!!! รับสิทธิประโยชน์มากมาย...</li>
                        <li>ซื้อสินค้าราคาพิเศษเฉพาะสมาชิก...</li>
                    </ol>
                ', // ใส่เนื้อหาคร่าวๆ ไปก่อน เดี๋ยวไปแก้ในหน้า Admin ได้
                'images' => [] // เริ่มต้นไม่มีรูปเสริม
            ]
            
            );
             PageContent::updateOrCreate(
            ['page_key' => 'board'],
            [
                'title' => 'สิทธิประโยชน์สำหรับผู้ถือหุ้น (Shareholders)',
                'subtitle' => 'ซื้อหุ้น ร้านสหกรณ์มหาวิทยาลัยเชียงใหม่ รับสิทธิพิเศษอะไรบ้าง',
                'content' => '
                    <ol class="list-group list-group-numbered" style="font-size: 1.1rem;">
                        <li class="list-group-item border-0 py-3">
                            ซื้อหุ้นเพิ่ม <span class="fw-bold text-primary">20 หุ้นขึ้นไป</span> สามารถมาเล่นเกม <span class="fw-bold text-success">“ ตักไข่นำโชค ”</span> รับของรางวัล ได้ที่จุดบริการลูกค้าสัมพันธ์
                        </li>
                        <li class="list-group-item border-0 py-3">
                            <span class="fw-bold text-danger">พิเศษ!!!</span> นักศึกษาใหม่ สมัคร หุ้น 100 หุ้น หรือ 2000 บาท ขึ้นไป เมื่อเรียนจบ สามารถมารับ ของขวัญจากทางร้าน สหกรณ์ มช. เป็น <span class="fw-bold text-success">เงินสด มูลค่า 400 บาท !!!</span> <br>
                            <span class="ms-2 badge bg-warning text-dark mt-1">( เฉพาะ นักศึกษาใหม่ ปี 68 เท่านั้น )</span>
                        </li>
                        <li class="list-group-item border-0 py-3">
                            สมาชิก ซื้อหุ้น <span class="fw-bold">2,500 บาท</span> รับทันที <span class="fw-bold" style="color: #6f42c1;">ตุ๊กตาช้างม่วง</span> <br>
                            <span class="text-muted small ms-2">( หลังจากซื้อหุ้นแล้ว ต้องเป็นผู้ถือหุ้นอย่างน้อย 1 ปี )</span>
                        </li>
                        <li class="list-group-item border-0 py-3">
                            สมาชิก ซื้อหุ้น <span class="fw-bold">2,500 บาท</span> สามารถนำสินค้ามาฝากขายที่ร้านสหกรณ์มหาวิทยาลัยเชียงใหม่ได้
                            <ul class="list-unstyled mt-2 ms-3 text-secondary" style="font-size: 1rem;">
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> ไม่มีค่าเช่าสถานที่ / ไม่มีค่าเช่าแผง</li>
                                <li><i class="bi bi-dash-circle text-danger me-2"></i> ของแห้ง หัก 25 % จากราคาขาย</li>
                                <li><i class="bi bi-dash-circle text-danger me-2"></i> ของสด หรือ ของที่ต้องใส่ตู้แช่ หัก 30 % จากราคาขาย</li>
                            </ul>
                        </li>
                        <li class="list-group-item border-0 py-3">
                            สมาชิก ซื้อหุ้น <span class="fw-bold">เกิน 125 หุ้นขึ้นไป หรือ 2,500 บาท</span> รับทันที!!! <span class="fw-bold" style="color: #6f42c1;">ตุ๊กตาน้องช้างม่วง</span>
                        </li>
                        <li class="list-group-item border-0 py-3">
                            สามารถเข้าร่วม <span class="fw-bold text-primary">กิจกรรม Workshop พิเศษ</span> ที่ทางร้านสหกรณ์มหาวิทยาลัยเชียงใหม่จัดขึ้นได้ทุกเดือน
                        </li>
                        <li class="list-group-item border-0 py-3">
                            ลุ้นรับรางวัลจากกิจกรรม จับฉลากแจกของขวัญสมาชิกในทุกเดือน
                        </li>
                    </ol>

                    <div class="alert alert-danger mt-4 text-center border-2" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>
                            ผู้ถือหุ้น หรือ สมาชิก ต้องมาใช้บริการ และ แจ้งเลขสมาชิกก่อนชำระค่าสินค้าที่ร้าน <br>
                            อย่างน้อยปีละ 1 ครั้ง เพื่อต่ออายุและรักษาสภาพสมาชิก
                        </strong>
                    </div>
                ',
                'images' => []
            ]
        );
    }
}
   