<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MembersImport;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    // แสดงรายชื่อสมาชิก + ฟอร์ม Import
   public function index(Request $request)
    {
        // รับค่าจากช่องค้นหาแต่ละช่อง
        $member_id = $request->input('member_id');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $phone = $request->input('phone');

        // ใช้ query แบบ AND (ยิ่งกรอกเยอะ ยิ่งกรองแคบลง)
        $members = Member::query()
            ->when($member_id, function($q) use ($member_id) {
                return $q->where('member_id', 'like', "%$member_id%");
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
            ->orderBy('id', 'desc')
            ->paginate(20); // แบ่งหน้าทีละ 20

        // ส่งค่าเดิมกลับไปที่หน้า View ด้วย (เพื่อให้ช่องกรอกไม่หายตอนกดค้นหา)
        return view('admin.members.index', compact('members', 'member_id', 'first_name', 'last_name', 'phone'));
    }

    // ฟังก์ชัน Import Excel
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new MembersImport, $request->file('file'));
            return back()->with('success', 'นำเข้าข้อมูลสำเร็จ!');
        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }

    // ฟอร์มเพิ่มสมาชิก (Manual)
    public function create()
    {
        return view('admin.members.create');
    }

    // บันทึกสมาชิกใหม่
    public function store(Request $request)
    {
        // validate ข้อมูลตามต้องการ
        Member::create($request->all());
        return redirect()->route('admin.members.index')->with('success', 'เพิ่มสมาชิกสำเร็จ');
    }

    // ฟอร์มแก้ไข
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('admin.members.edit', compact('member'));
    }

    // อัปเดตข้อมูล
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $member->update($request->all());
        return redirect()->route('admin.members.index')->with('success', 'แก้ไขข้อมูลสำเร็จ');
    }

    // ลบข้อมูล
    public function destroy($id)
    {
        Member::findOrFail($id)->delete();
        return back()->with('success', 'ลบข้อมูลสำเร็จ');
    }
    public function truncate(Request $request)
    {
        // 1. ตรวจสอบว่ากรอกรหัสผ่านมาไหม
        $request->validate([
            'password' => 'required',
        ]);

        // 2. เช็คว่ารหัสผ่านที่กรอกมา ตรงกับรหัสผ่านของ Admin ที่ Login อยู่ไหม
        if (!Hash::check($request->password, auth()->user()->password)) {
            // ถ้ารหัสผิด ให้เด้งกลับไปพร้อมแจ้งเตือน
            return back()->with('error', 'รหัสผ่านไม่ถูกต้อง! ไม่สามารถลบข้อมูลได้');
        }

        // 3. ถ้ารหัสถูก -> ล้างข้อมูลทั้งหมด (Truncate จะรีเซ็ต ID กลับเป็น 1 ด้วย)
        Member::truncate();

        return back()->with('success', 'ล้างข้อมูลสมาชิกทั้งหมดเรียบร้อยแล้ว');
    }
}