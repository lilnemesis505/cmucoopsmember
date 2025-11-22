<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Banner;
use ImageKit\ImageKit;
use Illuminate\Support\Facades\DB; // <--- เพิ่มบรรทัดนี้เพื่อใช้ Transaction

class SlideController extends Controller
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
        $slides = Slide::orderBy('id', 'asc')->get();
        $banners = Banner::orderBy('id', 'asc')->get();
        return view('admin.slides.index', compact('slides', 'banners'));
    }

    // ===============================================================
    // ส่วนที่แก้ไขใหม่: สร้าง DB ก่อน -> เอา ID มาตั้งชื่อไฟล์ -> อัปโหลด -> อัปเดต DB
    // ===============================================================
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'type' => 'required|in:slide,banner',
        ]);

        // เช็ค Banner ห้ามเกิน 2 รูป
        if ($request->type == 'banner' && Banner::count() >= 2) {
            return back()->with('error', 'อัปโหลดล้มเหลว! มีแบนเนอร์ครบ 2 รูปแล้ว');
        }

        // เริ่ม Transaction (ถ้า error กลางทาง จะย้อนข้อมูลคืนทั้งหมด)
        DB::beginTransaction();

        try {
            // 1. สร้างข้อมูลลง Database ก่อน เพื่อจอง ID (ใส่ค่าว่างไว้ก่อน)
            if ($request->type == 'slide') {
                $item = new Slide();
                $prefix = 'Slide_'; // ชื่อนำหน้าสำหรับ Slide
                $folder = '/main/slide/';
            } else {
                $item = new Banner();
                $prefix = 'Banner_'; // ชื่อนำหน้าสำหรับ Banner
                $folder = '/main/';
            }

            // ใส่ข้อมูลชั่วคราว (เพื่อไม่ให้ติด Error Not Null ใน DB ถ้ามี)
            $item->image_url = 'pending...';
            $item->file_id = 'pending...';
            $item->save(); // บันทึกเพื่อเอา ID

            // 2. ได้ ID มาแล้ว ($item->id) นำมาตั้งชื่อไฟล์
            $newFileName = $prefix . $item->id; // ผลลัพธ์: Slide_1, Banner_5 ฯลฯ

            $file = $request->file('image');

            // 3. อัปโหลดขึ้น ImageKit
            $upload = $this->imageKit->upload([
                'file' => fopen($file->getRealPath(), 'r'),
                'fileName' => $newFileName,     // ใช้ชื่อที่เราตั้งเอง
                'folder' => $folder,
                'useUniqueFileName' => false,   // สำคัญ! ต้องปิด เพื่อให้ใช้ชื่อตามที่เรากำหนดเป๊ะๆ
                'overwrite' => true             // ทับไฟล์เดิมถ้าชื่อซ้ำ (กันเหนียว)
            ]);

           if (isset($upload->error) && $upload->error) {
                // ถ้า error เป็น string ให้ใช้เลย, ถ้าเป็น object ให้ดึง message
                $realErrorMessage = is_string($upload->error) 
                                    ? $upload->error 
                                    : ($upload->error->message ?? 'Unknown Error');
                
                throw new \Exception('ImageKit Error: ' . $realErrorMessage);
            }
            // 4. อัปโหลดสำเร็จ -> อัปเดตข้อมูลจริงกลับเข้า Database
            $item->image_url = $upload->result->url;
            $item->file_id = $upload->result->fileId;
            $item->save();

            // ยืนยันการทำงานกับ Database
            DB::commit();

            return back()->with('success', 'อัปโหลดเรียบร้อยแล้ว (ID: ' . $item->id . ')');

        } catch (\Exception $e) {
            // ถ้าเกิด Error ให้ยกเลิกการบันทึก Database (Row ที่สร้างไว้ตอนแรกจะหายไป)
            DB::rollBack();
            return back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }

    // ฟังก์ชัน destroy เหมือนเดิม...
    public function destroy(Request $request, $id)
    {
        // ... (ใช้โค้ดเดิมของคุณได้เลยครับ)
        $type = $request->input('type'); 

        try {
            if ($type == 'slide') {
                $item = Slide::findOrFail($id);
            } elseif ($type == 'banner') {
                $item = Banner::findOrFail($id);
            } else {
                return back()->with('error', 'ไม่พบประเภทข้อมูล');
            }

            if ($item->file_id) {
                $delete = $this->imageKit->deleteFile($item->file_id);
                // จัดการ error ตามต้องการ
            }

            $item->delete();
            return back()->with('warning', 'ลบข้อมูลเรียบร้อยแล้ว');

        } catch (\Exception $e) {
            return back()->with('error', 'ลบไม่สำเร็จ: ' . $e->getMessage());
        }
    }
    public function syncFromImageKit()
    {
        $addedSlides = 0;
        $addedBanners = 0;

        try {
            // ---------------------------------------------------
            // 1. จัดการ Slide (ดึงจากโฟลเดอร์ /main/slide/)
            // ---------------------------------------------------
            $slideFiles = $this->imageKit->listFiles([
                'path' => '/main/slide/',
                'limit' => 100 // ดึงสูงสุด 100 รูป (ปรับเพิ่มได้ถ้ามีเยอะ)
            ]);

            if (!empty($slideFiles->result)) {
                foreach ($slideFiles->result as $file) {
                    // ตรวจสอบว่าชื่อไฟล์ขึ้นต้นด้วย Slide_ หรือไม่ และต้องยังไม่มีใน DB
                    // (ใช้ strpos หรือ str_starts_with เพื่อเช็คชื่อไฟล์)
                    $isSlideFile = strpos($file->name, 'Slide_') === 0;
                    $existsInDB = Slide::where('file_id', $file->fileId)->exists();

                    if ($isSlideFile && !$existsInDB) {
                        Slide::create([
                            'file_id' => $file->fileId,
                            'image_url' => $file->url,
                            // อาจจะใส่ created_at ตามเวลาไฟล์ก็ได้ถ้าต้องการ
                        ]);
                        $addedSlides++;
                    }
                }
            }

            // ---------------------------------------------------
            // 2. จัดการ Banner (ดึงจากโฟลเดอร์ /main/)
            // ---------------------------------------------------
            $bannerFiles = $this->imageKit->listFiles([
                'path' => '/main/', // ตาม logic เก่า Banner อยู่ข้างนอก
                'limit' => 100
            ]);

            if (!empty($bannerFiles->result)) {
                foreach ($bannerFiles->result as $file) {
                    // Banner ต้องชื่อขึ้นต้นด้วย Banner_ เท่านั้น (เพื่อกันไม่ให้ไปดึงไฟล์อื่นใน folder main)
                    $isBannerFile = strpos($file->name, 'Banner_') === 0;
                    $existsInDB = Banner::where('file_id', $file->fileId)->exists();

                    if ($isBannerFile && !$existsInDB) {
                        Banner::create([
                            'file_id' => $file->fileId,
                            'image_url' => $file->url
                        ]);
                        $addedBanners++;
                    }
                }
            }

            return back()->with('success', "ซิงค์ข้อมูลสำเร็จ! พบ Slide ใหม่: $addedSlides, Banner ใหม่: $addedBanners");

        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาดในการซิงค์: ' . $e->getMessage());
        }
    }
}