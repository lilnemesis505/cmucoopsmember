<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ImageKit\ImageKit;

class PageController extends Controller
{
    protected $imageKit;

    public function __construct()
    {
        $this->imageKit = new ImageKit(
            config('services.imagekit.public_key'),
            config('services.imagekit.private_key'),
            config('services.imagekit.url_endpoint')
        );
    }

    // --- ส่วนหน้าบ้าน (Public) ---
    public function showMemberCheck()
    {
        // ดึงข้อมูล ถ้าไม่มีให้สร้าง default ไว้
        $page = Page::firstOrCreate(
            ['key' => 'member_check'],
            ['title' => 'ตรวจสอบข้อมูลสมาชิก', 'content' => '<p>เนื้อหาเริ่มต้น...</p>']
        );

        return Inertia::render('MemberCheck/Home', [
            'page' => $page
        ]);
    }

    // --- ส่วนหลังบ้าน (Admin) ---
    public function editMemberCheck()
    {
        $page = Page::firstOrCreate(['key' => 'member_check'], ['title' => 'ตรวจสอบข้อมูลสมาชิก']);
       return Inertia::render('Admin/MemberCheck/Edit', [
    'page' => $page,
    'pageKey' => 'member_check',
    'updateRoute' => 'admin.member_check.update' // ส่งชื่อ Route ใหม่ไป
]);
    }

    public function update(Request $request, $key)
    {
        $page = Page::where('key', $key)->firstOrFail();
        
        $data = $request->validate([
            'title' => 'required|string',
            'subtitle' => 'nullable|string',
            'content' => 'nullable|string',
        ]);

        // จัดการรูปปก (Cover Image)
        if ($request->hasFile('cover_image')) {
            $upload = $this->imageKit->upload([
                'file' => fopen($request->file('cover_image'), 'r'),
                'fileName' => "cover_{$key}_" . time(),
                'folder' => "/pages/{$key}/"
            ]);
            $data['image_url'] = $upload->result->url;
        }

        // จัดการลบรูปปก (ถ้า user สั่งลบ)
        if ($request->boolean('remove_cover')) {
             $data['image_url'] = null;
        }

        // จัดการ Gallery (ถ้ามี logic เพิ่มรูป/ลบรูป ใส่ตรงนี้ได้ครับ)
        
        $page->update($data);

        return back()->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }
}