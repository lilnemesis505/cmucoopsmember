<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MembersImport implements ToModel, WithHeadingRow
{
    public function uniqueBy()
    {
        return 'member_id'; // <--- 3. เพิ่มฟังก์ชันนี้
    }
    public function headingRow(): int
    {
        return 3;
    }
   public function model(array $row)
    {
        // เช็คก่อนว่าแถวนั้นมีชื่อไหม (ป้องกันแถวว่าง)
        if (!isset($row['firstname']) && !isset($row['firstna'])) {
            return null;
        }

        // เตรียมข้อมูล Member ID (จากไฟล์ Excel หัวตารางอาจพิมพ์ไม่เต็ม)
        $memberId = $row['registr'] ?? $row['registry_no_2'] ?? null;

        // ถ้าไม่มี Member ID ให้ข้ามไปเลย (เพราะเราใช้เป็น Key ในการอัปเดต)
        if (!$memberId) {
            return null;
        }

        return new Member([
            // ระบุคอลัมน์ที่จะใช้เช็คและอัปเดต
            'member_id'     => $memberId,
            
            // ข้อมูลอื่นๆ ที่จะถูกอัปเดตทับของเดิม
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
     * ฟังก์ชันแปลงวันที่ไทย (1/04/2516) -> Database (1973-04-01)
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