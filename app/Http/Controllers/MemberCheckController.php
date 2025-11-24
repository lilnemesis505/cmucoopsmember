<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MembersImport;

class MemberCheckController extends Controller
{
    // 1. หน้าค้นหาและแสดงผล
   public function index(Request $request)
    {
        // รับค่าจากช่องค้นหา (เพิ่ม id_card)
        $member_id = $request->input('member_id');
        $id_card = $request->input('id_card'); // <--- เพิ่มใหม่
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $phone = $request->input('phone');

        // เช็คว่ามีการกรอกข้อมูลอย่างน้อย 1 ช่อง
        $hasSearch = $member_id || $id_card || $first_name || $last_name || $phone;

        $members = collect();

        if ($hasSearch) {
            $members = Member::query()
                ->when($member_id, function($q) use ($member_id) {
                    return $q->where('member_id', 'like', "%$member_id%");
                })
                ->when($id_card, function($q) use ($id_card) { // <--- Logic ค้นหาเลขบัตร
                    return $q->where('id_card', 'like', "%$id_card%");
                })
                ->when($first_name, function($q) use ($first_name) {
                    return $q->where('first_name', 'like', "%$first_name%");
                })
                ->when($last_name, function($q) use ($last_name) {
                    return $q->where('last_name', 'like', "%$last_name%");
                })
                ->when($phone, function($q) use ($phone) {
                    return $q->where('phone', 'like', "%$phone%");
                })
                ->orderBy('member_id', 'asc')
                ->paginate(20); 
        }

        // ส่งตัวแปร id_card กลับไปที่ View ด้วย
        return view('pages.check_member', compact('members', 'member_id', 'id_card', 'first_name', 'last_name', 'phone', 'hasSearch'));
    }
    // ฟังก์ชัน import (คงเดิม หรือลบออกก็ได้ถ้าให้ Admin ทำคนเดียว)
    public function import(Request $request) 
    {
       // ... (ใช้โค้ดเดิมของคุณได้เลย)
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new MembersImport, $request->file('file'));
            return back()->with('success', 'นำเข้าข้อมูลสมาชิกเรียบร้อยแล้ว!');
        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }
}