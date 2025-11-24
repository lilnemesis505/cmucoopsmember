<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventImage;
use ImageKit\ImageKit;

class EventController extends Controller
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
        // แสดงรายการ ev1 - ev6 ให้เลือก
        return view('admin.events.index');
    }

    public function edit($key)
    {
        // หา Event จาก Key (เช่น ev1) ถ้าไม่มีสร้างใหม่รอไว้เลย
        $event = Event::firstOrCreate(['key' => $key]);
        
        // ดึงรูปภาพทั้งหมดของ event นี้
        $images = $event->images()->orderBy('id', 'desc')->get();

        return view('admin.events.edit', compact('event', 'images', 'key'));
    }

    public function updateDetails(Request $request, $key)
    {
        $event = Event::where('key', $key)->firstOrFail();
        $event->update([
            'title' => $request->event_title,
            'description' => $request->event_description
        ]);

        return back()->with('success', 'บันทึกรายละเอียดสำเร็จ');
    }

    public function uploadImage(Request $request, $key)
    {
        $request->validate(['event_image' => 'required|image']);
        $event = Event::where('key', $key)->firstOrFail();

        try {
            $file = $request->file('event_image');
            
            // Upload ImageKit
            $upload = $this->imageKit->upload([
                'file' => fopen($file->getRealPath(), 'r'),
                'fileName' => $key . '_' . time(),
                'folder' => "/event/{$key}/"
            ]);

            // Save DB (ตาราง event_images)
            $event->images()->create([
                'image_url' => $upload->result->url,
                'file_id' => $upload->result->fileId
            ]);

            return back()->with('success', 'อัปโหลดรูปภาพสำเร็จ');

        } catch (\Exception $e) {
            return back()->with('error', 'Upload Error: ' . $e->getMessage());
        }
    }

    public function deleteImage(Request $request, $id)
    {
        $image = EventImage::findOrFail($id);

        // Delete from ImageKit
        if ($image->file_id) {
            $this->imageKit->deleteFile($image->file_id);
        }

        $image->delete();
        return back()->with('warning', 'ลบรูปภาพสำเร็จ');
    }
    public function syncFromImageKit()
    {
        $eventKeys = ['ev1', 'ev2', 'ev3', 'ev4', 'ev5', 'ev6'];
        $totalSynced = 0;

        try {
            foreach ($eventKeys as $key) {
                // 1. หา Event นั้นๆ ใน DB (ถ้าไม่มีให้สร้างใหม่กัน error)
                $event = Event::firstOrCreate(['key' => $key], [
                    'title' => "Event $key",
                    'description' => "-"
                ]);

                // 2. กำหนดโฟลเดอร์ใน ImageKit ที่จะไปค้นหา
                // *** สำคัญ: แก้ตรงนี้ให้ตรงกับที่คุณเคยอัปโหลดไว้ ***
                // เช่นถ้าเคยอัปไว้ที่ /main/ev1/ ก็แก้เป็น "/main/$key/"
                $folderPath = "/main/events/$key/"; 

                // 3. ดึงรายการไฟล์จาก ImageKit
                $files = $this->imageKit->listFiles([
                    'path' => $folderPath,
                    'limit' => 100
                ]);

                if (!empty($files->result)) {
                    foreach ($files->result as $file) {
                        // 4. เช็คว่ามีรูปนี้ใน DB หรือยัง (เช็คจาก file_id)
                        $exists = EventImage::where('file_id', $file->fileId)->exists();

                        if (!$exists) {
                            // 5. ถ้ายังไม่มี ให้สร้างใหม่
                            EventImage::create([
                                'event_id' => $event->id,
                                'file_id' => $file->fileId,
                                'image_url' => $file->url,
                                // 'file_name' => $file->name // (ถ้ามีคอลัมน์นี้)
                            ]);
                            $totalSynced++;
                        }
                    }
                }
            }

            return back()->with('success', "ซิงค์ข้อมูลเสร็จสิ้น! ดึงรูปกลับมาได้ทั้งหมด $totalSynced รูป");

        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาดในการซิงค์: ' . $e->getMessage());
        }
    }
}