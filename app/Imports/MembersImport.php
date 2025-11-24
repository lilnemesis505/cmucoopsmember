<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MembersImport implements ToModel, WithHeadingRow
{
    public function headingRow(): int
    {
        return 3;
    }
   public function model(array $row)
    {
        // เช็คก่อนว่ามีข้อมูลไหม (ป้องกันแถวว่าง)
        if (!isset($row['registry_no_2']) && !isset($row['firstname'])) {
            return null;
        }

        return new Member([
            // ฝั่งซ้าย = ชื่อใน Database (Model)
            // ฝั่งขวา = ชื่อหัวตารางใน Excel (ตัวพิมพ์เล็กทั้งหมด ห้ามมีเว้นวรรค)
            
            'member_id'     => $row['registry_no_2'] ?? null,  // REGISTRY_NO_2
            'id_card'       => $row['idcard'] ?? null,         // IDCARD
            'title_name'    => $row['titlename'] ?? null,      // TITLENAME
            'first_name'    => $row['firstname'],              // FIRSTNAME
            'last_name'     => $row['lastname'],               // LASTNAME
            'nation'        => $row['nation'] ?? 'TH',         // NATION
            
            // แปลงวันที่จาก พ.ศ. เป็น ค.ศ. (เรียกฟังก์ชันด้านล่าง)
            'registry_date' => $this->transformDate($row['registry_date'] ?? null), 

            'phone'         => $row['tel_no'] ?? null,         // TEL_NO
            
            // ที่อยู่
            'loc_addr'      => $row['loc_addr'] ?? null,       // LOC_ADDR
            'tambon'        => $row['tambon_name'] ?? null,    // TAMBON_NAME
            'amphur'        => $row['amphur_name'] ?? null,    // AMPHUR_NAME
            'province'      => $row['province_name'] ?? null,  // PROVINCE_NAME
            'zip_code'      => $row['zip_code'] ?? null,       // ZIP_CODE
        ]);
    }

    /**
     * ฟังก์ชันแปลงวันที่ไทย (1/04/2516) -> Database (1973-04-01)
     */
    private function transformDate($value)
    {
        if (!$value || trim($value) == '-' || trim($value) == '') {
            return null;
        }

        try {
            // ถ้า Excel ส่งมาเป็นตัวเลข (Serial Number) ของ Excel เอง
            if (is_numeric($value)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
            }

            // ถ้ามาเป็น String "1/04/2516"
            // แยกวัน เดือน ปี ออกจากกัน
            $parts = explode('/', $value);
            if (count($parts) == 3) {
                $d = (int)$parts[0];
                $m = (int)$parts[1];
                $y = (int)$parts[2];

                // ถ้าปีมากกว่า 2400 แสดงว่าเป็น พ.ศ. ให้ลบ 543
                if ($y > 2400) {
                    $y -= 543;
                }

                // ส่งกลับเป็น Y-m-d
                return sprintf('%04d-%02d-%02d', $y, $m, $d);
            }

            return null; // แปลงไม่ได้ให้เป็น null
        } catch (\Exception $e) {
            return null;
        }
    }
}