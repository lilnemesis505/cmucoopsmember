<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts; // <--- 1. ต้อง Import ตัวนี้
use Carbon\Carbon;

// 2. ต้องเพิ่ม WithUpserts เข้าไปใน implements
class MembersImport implements ToModel, WithHeadingRow, WithUpserts 
{
    /**
     * บอกระบบว่าให้เช็คซ้ำที่คอลัมน์ member_id
     */
    public function uniqueBy()
    {
        return 'member_id';
    }

    /**
     * กำหนดบรรทัดที่เป็นหัวตาราง (Key ภาษาอังกฤษ) = บรรทัด 3
     */
    public function headingRow(): int
    {
        return 3;
    }

    public function model(array $row)
    {
        // =========================================================
        // 3. ส่วนกรองข้อมูล (Filter) ป้องกันแถวว่างและแถวหัวตารางไทย
        // =========================================================

        // ดึงค่า member_id ออกมาก่อน (รองรับ key หลายแบบ)
        $memberId = $row['registr'] ?? $row['registry_no_2'] ?? null;

        // ถ้าไม่มี Member ID หรือเป็นค่าว่าง -> ข้าม
        if (!$memberId || trim($memberId) === '') {
            return null;
        }

        // *** ดักจับแถวหัวตารางภาษาไทย (บรรทัดที่ 4) ***
        // ถ้าค่าในช่อง ID เป็นคำว่า "เลขสมาชิก" ให้ข้ามไปเลย ไม่ต้องบันทึก
        if ($memberId === 'เลขสมาชิก') {
            return null;
        }

        // =========================================================
        // 4. บันทึก/อัปเดตข้อมูล
        // =========================================================
        return new Member([
            'member_id'     => $memberId,
            
            // ข้อมูลอื่นๆ
            'id_card'       => $row['idcard'] ?? null,
            'title_name'    => $row['titlena'] ?? $row['titlename'] ?? null,
            'first_name'    => $row['firstna'] ?? $row['firstname'],
            'last_name'     => $row['lastnam'] ?? $row['lastname'],
            'nation'        => $row['nation'] ?? 'TH',
            
            // แปลงวันที่
            'registry_date' => $this->transformDate($row['registr_1'] ?? $row['registry_date'] ?? null), 

            'phone'         => $row['tel_no'] ?? null,
            
            // ที่อยู่
            'loc_addr'      => $row['loc_addr'] ?? null,
            'tambon'        => $row['tambon'] ?? $row['tambon_name'] ?? null,
            'amphur'        => $row['amphur'] ?? $row['amphur_name'] ?? null,
            'province'      => $row['provinc'] ?? $row['province_name'] ?? null,
            'zip_code'      => $row['zip_cod'] ?? $row['zip_code'] ?? null,
        ]);
    }

    /**
     * ฟังก์ชันแปลงวันที่
     */
    private function transformDate($value)
    {
        if (!$value || trim($value) == '-' || trim($value) == '') {
            return null;
        }

        try {
            if (is_numeric($value)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
            }

            $parts = explode('/', $value);
            if (count($parts) == 3) {
                $d = (int)$parts[0];
                $m = (int)$parts[1];
                $y = (int)$parts[2];
                if ($y > 2400) $y -= 543;
                return sprintf('%04d-%02d-%02d', $y, $m, $d);
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}