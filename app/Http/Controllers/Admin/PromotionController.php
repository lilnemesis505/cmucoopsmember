<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;
use ImageKit\ImageKit;

class PromotionController extends Controller
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

    // แสดงรายการ
    public function index()
    {
        $promotions = Promotion::all();
        return view('admin.promotions.index', compact('promotions'));
    }

    // อัปเดตข้อมูล
    public function updateAll(Request $request)
    {
        $inputs = $request->input('promotions'); // รับข้อมูลทั้งหมดมาเป็น Array

        if ($inputs) {
            foreach ($inputs as $id => $data) {
                $promo = Promotion::find($id);
                
                if ($promo) {
                    // 1. อัปเดตข้อความ
                    $promo->main_title = $data['main_title'];
                    $promo->subtitle = $data['subtitle'];

                    // 2. จัดการรูปภาพ (เช็คว่ามีการอัปโหลดใหม่ใน ID นี้หรือไม่)
                    if ($request->hasFile("promotions.$id.image")) {
                        try {
                            // ลบรูปเก่า
                            if ($promo->file_id) {
                                $this->imageKit->deleteFile($promo->file_id);
                            }

                            // อัปโหลดรูปใหม่
                            $file = $request->file("promotions.$id.image");
                            $upload = $this->imageKit->upload([
                                'file' => fopen($file->getRealPath(), 'r'),
                                'fileName' => 'promo_' . $id . '_' . time(),
                                'folder' => '/main/promotions/'
                            ]);

                            $promo->image_url = $upload->result->url;
                            $promo->file_id = $upload->result->fileId;

                        } catch (\Exception $e) {
                            // ถ้าอัปรูปพลาด ข้ามไปทำตัวอื่นต่อ หรือจะ return error ก็ได้
                            continue; 
                        }
                    }

                    $promo->save();
                }
            }
        }

        return back()->with('success', 'บันทึกข้อมูลทั้งหมดเรียบร้อยแล้ว');
    }
}