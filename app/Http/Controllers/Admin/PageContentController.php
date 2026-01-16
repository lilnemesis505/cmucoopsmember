<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageContent;
use ImageKit\ImageKit;
use Inertia\Inertia;
use App\Models\Page;

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

        // ✅ 2. เพิ่มส่วนนี้ครับ: เช็คว่ามีการสั่งลบรูปหรือไม่
        // ต้องเช็คก่อนการอัปโหลดรูปใหม่ เพื่อให้แน่ใจว่าถ้า user กดลบ มันจะลบออกก่อน
        if ($request->boolean('remove_cover')) {
            $page->image_url = null; // สั่งเคลียร์ค่าใน Database ให้เป็นว่าง
        }

        // 3. จัดการรูปปก (Cover Image) - ถ้ามีการอัปโหลดรูปใหม่ ให้บันทึกทับลงไป
        if ($request->hasFile('cover_image')) {
            try {
                $upload = $this->imageKit->upload([
                    'file' => fopen($request->file('cover_image'), 'r'),
                    'fileName' => 'cover_' . $key . '_' . time(),
                    'folder' => '/main/covers/'
                ]);
                
                $page->image_url = $upload->result->url;
                
            } catch (\Exception $e) {
                return back()->with('error', 'อัปโหลดรูปปกไม่สำเร็จ: ' . $e->getMessage());
            }
        }

        // 4. จัดการรูปภาพ Gallery (คงโค้ดเดิมไว้)
        $currentImages = $page->images ?? [];

        if ($request->hasFile('upload_images')) {
            foreach ($request->file('upload_images') as $file) {
                try {
                    $upload = $this->imageKit->upload([
                        'file' => fopen($file->getRealPath(), 'r'),
                        'fileName' => $key . '_' . time(),
                        'folder' => '/main/pages/'
                    ]);
                    $currentImages[] = $upload->result->url;
                } catch (\Exception $e) {
                    // ignore error
                }
            }
        }

        if ($request->has('remove_images')) {
            $currentImages = array_diff($currentImages, $request->remove_images);
        }

        $page->images = array_values($currentImages);
        
        // 5. บันทึกข้อมูล
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
 
        $page = PageContent::where('page_key', $key)->firstOrFail();
        
        // 2. Validate ข้อมูล
        $request->validate([
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048', 
        ]);

        // 3. อัปเดต Title และ Subtitle
        $page->title = $request->title;
        $page->subtitle = $request->subtitle;

        // 4. อัปโหลดรูป (ถ้ามี)
        if ($request->hasFile('cover_image')) {
            try {
                $upload = $this->imageKit->upload([
                    'file' => fopen($request->file('cover_image'), 'r'),
                    'fileName' => 'cover_' . $key . '_' . time(),
                    'folder' => '/main/covers/'
                ]);
                
                // บันทึก URL รูปลงฐานข้อมูล
                $page->image_url = $upload->result->url;
                
            } catch (\Exception $e) {
                return back()->with('error', 'อัปโหลดรูปไม่สำเร็จ: ' . $e->getMessage());
            }

            if ($request->boolean('remove_cover')) {
            $page->image_url = null; // เคลียร์ค่าใน Database ให้เป็น NULL
        }
        }

        // 5. บันทึกข้อมูล
        $page->save();

        return back()->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }
    public function editQrcode()
{
    $page = PageContent::where('page_key', 'qrcode')->firstOrFail();
    return Inertia::render('Admin/Qrcode/Edit', [
        'page' => $page,
        'pageKey' => 'qrcode'
    ]);
}
}