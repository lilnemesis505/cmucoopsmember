<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use ImageKit\ImageKit;
use Inertia\Inertia;

class BannerController extends Controller
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

    public function index()
    {
        return Inertia::render('Admin/Xcademy/BannerIndex', [
        'sliders' => Banner::where('type', 'slider')->latest()->get(),
        'staticBanner' => Banner::where('type', 'static')->first(),
    ]);
    }

    // อัปโหลดรูป Slide (เพิ่มได้หลายรูป)
    public function storeSlider(Request $request)
    {
        $request->validate(['image' => 'required|image|max:5120']); // Max 5MB

        try {
            $upload = $this->uploadToImageKit($request->file('image'), 'slider');

            Banner::create([
                'type' => 'slider',
                'image_url' => $upload->result->url,
                'file_id' => $upload->result->fileId,
            ]);

            return back()->with('success', 'เพิ่มรูปสไลด์สำเร็จ');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // อัปโหลดรูป Static (มีได้รูปเดียว ถ้าอัปใหม่จะทับของเดิม)
    public function updateStatic(Request $request)
    {
        $request->validate(['image' => 'required|image|max:5120']);

        try {
            // หาของเดิมก่อน
            $currentStatic = Banner::where('type', 'static')->first();

            // อัปโหลดรูปใหม่
            $upload = $this->uploadToImageKit($request->file('image'), 'static');

            // ถ้ามีของเดิม ให้ลบไฟล์เก่าที่ ImageKit ทิ้ง
            if ($currentStatic && $currentStatic->file_id) {
                $this->imageKit->deleteFile($currentStatic->file_id);
            }

            // บันทึก (ถ้ามี update, ถ้าไม่มี create)
            if ($currentStatic) {
                $currentStatic->update([
                    'image_url' => $upload->result->url,
                    'file_id' => $upload->result->fileId,
                ]);
            } else {
                Banner::create([
                    'type' => 'static',
                    'image_url' => $upload->result->url,
                    'file_id' => $upload->result->fileId,
                ]);
            }

            return back()->with('success', 'อัปเดตภาพโปสเตอร์ขวาสำเร็จ');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        
        if ($banner->file_id) {
            $this->imageKit->deleteFile($banner->file_id);
        }
        
        $banner->delete();

        return back()->with('success', 'ลบรูปภาพสำเร็จ');
    }

    // Helper Function
    private function uploadToImageKit($file, $subFolder)
    {
        return $this->imageKit->upload([
            'file' => fopen($file->getRealPath(), 'r'),
            'fileName' => $subFolder . '_' . time(),
            'folder' => "/banners/{$subFolder}/"
        ]);
    }
}