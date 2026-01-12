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
    public function uniqueBy()
    {
        return 'member_id';
    }

    public function headingRow(): int
    {
        return 3;
    }

    public function model(array $row)
    {
        $memberId = $row['registry_no_2'] ?? null;

        if (!$memberId || trim($memberId) === '') {
            return null;
        }

        if (trim($memberId) === 'เลขสมาชิก') {
            return null;
        }

        return new Member([
            'member_id'     => trim($memberId),
            
            // ข้อมูลส่วนตัว
            'id_card'       => $this->cleanString($row['idcard'] ?? null),
            'prefix'        => $this->cleanString($row['titlename'] ?? null),
            'first_name'    => $this->cleanString($row['firstname'] ?? null),
            'last_name'     => $this->cleanString($row['lastname'] ?? null),
            'nation'        => $this->cleanString($row['nation'] ?? 'TH'),
            
            // ข้อมูลสมาชิก (ตัด share_amount ออกแล้ว)
            'member_type'   => $this->cleanString($row['membertype'] ?? 'สามัญ'),
            
            // วันที่สมัคร
            'registry_date' => $this->transformDate($row['registry_date'] ?? null), 

            // ข้อมูลติดต่อ
            'phone'         => $this->cleanString($row['tel_no'] ?? null),
            
            // ที่อยู่
            'loc_addr'      => $this->cleanString($row['loc_addr'] ?? null),
            'tambon'        => $this->cleanString($row['tambon_name'] ?? null),
            'amphur'        => $this->cleanString($row['amphur_name'] ?? null),
            'province'      => $this->cleanString($row['province_name'] ?? null),
            'zip_code'      => $this->cleanString($row['zip_code'] ?? null),
        ]);
    }

    private function transformDate($value)
    {
        if (!$value || trim($value) == '-' || trim($value) == '') {
            return null;
        }
        try {
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            }
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    private function cleanString($value)
    {
        if (!$value || $value === '-') return null;
        return trim($value);
    }
}