<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageContent;
use ImageKit\ImageKit;

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
        return view('admin.promotions.pages.edit', compact('page', 'key'));
    }

    // บันทึกข้อมูล
    public function update(Request $request, $key)
    {
        $page = PageContent::where('page_key', $key)->firstOrFail();

        // 1. อัปเดตข้อความ
        $page->title = $request->title;
        $page->subtitle = $request->subtitle;
        $page->content = $request->input('content'); // เนื้อหาจาก Summernote

        // 2. จัดการรูปภาพ (ถ้ามีการอัปโหลดเพิ่ม)
        $currentImages = $page->images ?? []; // ดึงรูปเดิมมา

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
                    // Handle Error
                }
            }
        }

        // 3. ถ้ามีการลบรูป (รับค่าเป็น Array ของ URL ที่จะลบ)
        if ($request->has('remove_images')) {
            $currentImages = array_diff($currentImages, $request->remove_images);
        }

        $page->images = array_values($currentImages); // จัด index ใหม่
        $page->save();

        return back()->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }
}