<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;
use ImageKit\ImageKit;
use Inertia\Inertia;

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

    public function index()
    {
        $promotions = Promotion::all();
        // ส่งข้อมูลไปหน้า Vue
        return Inertia::render('Admin/Promotions/Index', [
            'promotions' => $promotions
        ]);
    }

    public function updateAll(Request $request)
    {
        // ... (Logic เดิม ไม่ต้องเปลี่ยน) ...
        $inputs = $request->input('promotions');

        if ($inputs) {
            foreach ($inputs as $id => $data) {
                $promo = Promotion::find($id);
                if ($promo) {
                    $promo->main_title = $data['main_title'];
                    $promo->subtitle = $data['subtitle'];

                    if ($request->hasFile("promotions.$id.image")) {
                        try {
                            if ($promo->file_id) $this->imageKit->deleteFile($promo->file_id);
                            
                            $file = $request->file("promotions.$id.image");
                            $upload = $this->imageKit->upload([
                                'file' => fopen($file->getRealPath(), 'r'),
                                'fileName' => 'promo_' . $id . '_' . time(),
                                'folder' => '/main/promotions/'
                            ]);
                            $promo->image_url = $upload->result->url;
                            $promo->file_id = $upload->result->fileId;
                        } catch (\Exception $e) { continue; }
                    }
                    $promo->save();
                }
            }
        }
        return back()->with('success', 'บันทึกข้อมูลทั้งหมดเรียบร้อยแล้ว');
    }
}