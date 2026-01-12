<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MembersImport implements ToModel, WithHeadingRow, WithUpserts 
{
    /**
     * บอกระบบว่าให้เช็คซ้ำที่คอลัมน์ member_id (ถ้ามีแล้วจะอัปเดตแทน)
     */
    public function uniqueBy()
    {
        return 'member_id';
    }

    /**
     * กำหนดบรรทัดที่เป็นหัวตาราง (Key ภาษาอังกฤษ)
     * จากไฟล์ CSV ของคุณ หัวตารางภาษาอังกฤษอยู่ที่บรรทัด 3
     */
    public function headingRow(): int
    {
        return 3;
    }

    public function model(array $row)
    {
        // 1. ดึง Member ID จากคอลัมน์ 'registry_no_2' (ตามไฟล์ Excel)
        $memberId = $row['registry_no_2'] ?? null;

        // ถ้าไม่มี Member ID หรือเป็นค่าว่าง -> ข้าม
        if (!$memberId || trim($memberId) === '') {
            return null;
        }

        // 2. ดักจับบรรทัดหัวตารางภาษาไทย (บรรทัดที่ 4) ที่อาจหลุดเข้ามา
        // ถ้าค่าในช่อง ID เป็นคำว่า "เลขสมาชิก" ให้ข้ามไปเลย
        if (trim($memberId) === 'เลขสมาชิก') {
            return null; 
        }

        // 3. เตรียมข้อมูลสำหรับบันทึก
        return new Member([
            'member_id'     => trim($memberId),
            
            // จับคู่คอลัมน์ตามไฟล์ Excel
            'prefix'        => $row['titlename'] ?? null,  // TITLENAME
            'firstname'     => $row['firstname'] ?? null,  // FIRSTNAME
            'lastname'      => $row['lastname'] ?? null,   // LASTNAME
            'nation'        => $row['nation'] ?? 'TH',     // NATION
            
            // แปลงวันที่จากคอลัมน์ registry_date
            'registry_date' => $this->transformDate($row['registry_date'] ?? null), 

            'phone'         => $row['tel_no'] ?? null,     // TEL_NO
            
            // ที่อยู่
            'loc_addr'      => $row['loc_addr'] ?? null,      // LOC_ADDR
            'tambon'        => $row['tambon_name'] ?? null,   // TAMBON_NAME
            'amphur'        => $row['amphur_name'] ?? null,   // AMPHUR_NAME
            'province'      => $row['province_name'] ?? null, // PROVINCE_NAME
            'zip_code'      => $row['zip_code'] ?? null,      // ZIP_CODE
        ]);
    }

    /**
     * ฟังก์ชันแปลงวันที่ (รองรับทั้งแบบ Excel Serial Number และ String)
     */
    private function transformDate($value)
    {
        if (!$value || trim($value) == '-' || trim($value) == '') {
            return null;
        }

        try {
            // กรณีเป็นตัวเลข (Excel Serial Date) เช่น 44725
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            }

            // กรณีเป็น String เช่น "2022-06-11" หรือ "11/06/2022"
            // ลองแปลงด้วย Carbon
            return Carbon::parse($value)->format('Y-m-d');

        } catch (\Exception $e) {
            // ถ้าแปลงไม่ได้จริงๆ ให้ส่งกลับเป็น null
            return null;
        }
    }
}