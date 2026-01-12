<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MembersImport;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

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
       return Inertia::render('Admin/Members/Index', [
            'members' => $members,
            'filters' => $request->only(['member_id', 'first_name', 'last_name', 'phone'])
        ]);
    }

    // ฟังก์ชัน Import Excel
    // Import Excel
    public function import(Request $request)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new MembersImport, $request->file('file'));
            return redirect()->back()->with('success', 'นำเข้าข้อมูลสำเร็จ!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }

    // ฟอร์มเพิ่มสมาชิก (Manual)
    public function create()
    {
        return Inertia::render('Admin/Members/Create');
    }

    // บันทึกสมาชิกใหม่
   public function store(Request $request)
    {
        // 1. ตรวจสอบข้อมูลเบื้องต้น (Validation)
        $request->validate([
            'member_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        // 2. เช็คว่ามีรหัสสมาชิกนี้ในระบบหรือยัง?
        // ค้นหาในตาราง members โดยดูที่คอลัมน์ member_id
        $exists = Member::where('member_id', $request->member_id)->exists();

        if ($exists) {
            // ถ้ามีแล้ว: ให้เด้งกลับไปพร้อมข้อความ Error (สีแดง)
            // (input จะหายไป แต่จะมีการแจ้งเตือนชัดเจน)
            return back()->with('error', "บันทึกล้มเหลว! รหัสสมาชิก '{$request->member_id}' มีอยู่ในระบบแล้ว");
        }

        // 3. ถ้ายังไม่มี: ให้บันทึกข้อมูลลง Database
        Member::create($request->all());

        // ส่งกลับพร้อมข้อความ Success (สีเขียว)
        return redirect()->route('admin.members.index')->with('success', 'เพิ่มสมาชิกสำเร็จ');
    }
    // ฟอร์มแก้ไข
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return Inertia::render('Admin/Members/Edit', [
            'member' => $member
        ]);
    }
    // อัปเดตข้อมูล
    public function update(Request $request, $id)
    {
        $request->validate([
            'member_id' => 'required|unique:members,member_id,' . $id,
        ]);

        $member = Member::findOrFail($id);
        $member->update($request->all());
        
        return redirect()->route('admin.members.index')->with('success', 'แก้ไขข้อมูลสำเร็จ');
    }

    // ลบข้อมูล
   public function destroy($id)
    {
        Member::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'ลบข้อมูลสำเร็จ');
    }
   public function truncate(Request $request)
    {
        $request->validate(['password' => 'required']);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return redirect()->back()->with('error', 'รหัสผ่านไม่ถูกต้อง!');
        }

        Member::truncate();
        return redirect()->back()->with('success', 'ล้างข้อมูลสมาชิกทั้งหมดเรียบร้อยแล้ว');
    }
}