<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageContent;
use ImageKit\ImageKit;
use Inertia\Inertia;

class PageContentController extends Controller
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

    // แสดงฟอร์มแก้ไข (รับค่า key เช่น 'member')
    public function edit($key)
    {
        $page = PageContent::where('page_key', $key)->firstOrFail();
        return Inertia::render('Admin/Pages/Edit', [
            'page' => $page,
            'pageKey' => $key
        ]);
    }

    // บันทึกข้อมูล
    public function update(Request $request, $key)
    {
        $page = PageContent::where('page_key', $key)->firstOrFail();

        // 1. อัปเดตข้อความ
        $page->title = $request->title;
        $page->subtitle = $request->subtitle;
        $page->content = $request->input('content');

        // 2. จัดการรูปปก (Cover Image)
        if ($request->hasFile('cover_image')) {
            try {
                // อัปโหลดรูปใหม่
                $upload = $this->imageKit->upload([
                    'file' => fopen($request->file('cover_image'), 'r'),
                    'fileName' => 'cover_' . $key . '_' . time(),
                    'folder' => '/main/covers/'
                ]);
                
                // บันทึกลงฐานข้อมูลช่อง image_url
                $page->image_url = $upload->result->url;
                
            } catch (\Exception $e) {
                return back()->with('error', 'อัปโหลดรูปปกไม่สำเร็จ: ' . $e->getMessage());
            }
        }

        // 3. จัดการรูปภาพ Gallery (ส่วนประกอบเนื้อหา)
        // เริ่มต้นดึงรูปเดิมมาเก็บไว้ก่อน
        $currentImages = $page->images ?? [];

        // 3.1 ถ้ามีการอัปโหลดรูปเพิ่ม
        if ($request->hasFile('upload_images')) {
            foreach ($request->file('upload_images') as $file) {
                try {
                    $upload = $this->imageKit->upload([
                        'file' => fopen($file->getRealPath(), 'r'),
                        'fileName' => $key . '_' . time(),
                        'folder' => '/main/pages/'
                    ]);
                    // เพิ่ม URL รูปลงไปใน Array
                    $currentImages[] = $upload->result->url;
                } catch (\Exception $e) {
                    // กรณีอัปโหลดไม่ผ่าน ข้ามไป
                }
            }
        }

        // 3.2 ถ้ามีการลบรูป (รับค่าเป็น Array ของ URL ที่จะลบ)
        if ($request->has('remove_images')) {
            $currentImages = array_diff($currentImages, $request->remove_images);
        }

        // บันทึก Gallery กลับเข้า Database
        $page->images = array_values($currentImages); // จัด index ใหม่ให้เรียงสวยงาม
        $page->save();

        return back()->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }
    public function editCover($key)
    {
        $page = PageContent::where('page_key', $key)->firstOrFail();
        return Inertia::render('Admin/Pages/EditCover', [ // หน้าใหม่สำหรับแก้ปกโดยเฉพาะ
            'page' => $page,
            'pageKey' => $key
        ]);
    }

    // ในไฟล์ PageContentController.php

public function updateCover(Request $request, $key)
{
    $page = Page::where('key', $key)->firstOrFail();
    
    // 1. เพิ่มการรับค่า title และ subtitle ใน validate
    $data = $request->validate([
        'title' => 'nullable|string',     // เพิ่มตรงนี้
        'subtitle' => 'nullable|string',  // เพิ่มตรงนี้
        'cover_image' => 'nullable|image|max:2048', // (Validation เดิมของรูป)
    ]);

    // 2. สั่งอัปเดต title และ subtitle
    $page->title = $request->title;
    $page->subtitle = $request->subtitle;

    // 3. ส่วนจัดการอัปโหลดรูป (Code เดิมของคุณ)
    if ($request->hasFile('cover_image')) {
        // ... (Code อัปโหลดรูป ImageKit เดิม) ...
        // $upload = ...
        // $page->image_url = $upload->result->url;
    }

    // 4. บันทึกข้อมูลลงฐานข้อมูล
    $page->save();

    return back()->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
}
}